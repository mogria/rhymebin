<?php

namespace App\Http\Controllers;

use App\Word;
use App\Syllable;
use App\SyllableMapping;
use App\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Eloquent\Lcs\LcsSolver;

define('VOCAL_POSITION_START',  0x04);
define('VOCAL_POSITION_MIDDLE', 0x02);
define('VOCAL_POSITION_END',    0x01);

class WordController extends Controller {
    private function convertSyllableWithMapping(Syllable $syllable, SyllableMapping $syllableMapping, $language_id, $with_examples = false) {
        return [
            'id' => $syllable->id,
            'syllable_number' => $syllableMapping->syllable_number,
            'syllable' => $syllable->syllable,
            'vowel' => $this->convertVowel($syllableMapping->vowel, $language_id, $with_examples)

        ];
    }
    private function convertWord($word, $language_id, $with_examples = false) {
        return [
            'id' => $word->id,
            'language_id' => $word->language->id,
            'word' => $word->word,
            'syllable_count' => $word->syllable_count,
            'syllables' => $word->syllableMappings()->get()->map(function($syllableMapping) use ($language_id, $with_examples) {
                return $this->convertSyllableWithMapping($syllableMapping->syllable, $syllableMapping, $language_id, $with_examples);
            })
        ];
    }

    public function getWords($language_id) {
        return Language::findOrFail($language_id)->words()->get()->map(function($word) use ($language_id) {
            return $this->convertWord($word, $language_id);
        });
    }

    
    public function getWord($language_id, $word_id) {
        $word = Word::with('syllableMappings', 'syllableMappings.syllable', 'syllableMappings.vowel')->where(['id' => $word_id, 'language_id' => $language_id])->first();
        if($word == null) {
            throw new \Illuminate\Database\ModelNotFoundException();
        }
        return $this->convertWord($word, $language_id, $with_examples = true);
    }
    
    public function postWords($language_id, Request $request) {
        $syllables = array_values($request->input('syllables'));
        $submittedWord = "";
        $syllableCount = count($syllables);
        foreach($syllables as $syllable) {
            $submittedWord .= $syllable['syllable'];
        }

        $wordData = ['word' => $submittedWord, 'language_id' => $language_id];

        $validator = Validator::make($wordData, [
            'word' => 'required|alpha|unique:words|between:1,255',
            'language_id' => 'required|exists:languages,id'
        ]);

        if($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }

        $previousSyllableEnd = 0;
        foreach($syllables as $index => $syllable) {
            $syllableValidator = Validator::make($syllable, [
                'vowel_id' => 'required|exists:vowels,id',
                'syllable' => 'required|alpha|between:1,255'
            ]);
            $syllableValidator->after(function($validator) use ($syllable, $previousSyllableEnd, $index, $syllableCount, $submittedWord) {
                if($syllable['start_index'] != $previousSyllableEnd) {
                    $validator->errors()->add('start_index', 'Invalid starting index for syllable');
                }
                if($index + 1 == $syllableCount && $syllable['end_index'] != mb_strlen($submittedWord)) { // if this is the last syllable, end index must match word length
                    $validator->errors()->add('end_index', 'Invalid ending index for syllable');
                }
            });

            $previousSyllableEnd = $syllable['end_index'];
            if($syllableValidator->fails()) {
                $this->throwValidationException($request, $syllableValidator);
            }
        }

        $word = new Word($wordData);
        $word->syllable_count = $syllableCount;
        $word->save();

        foreach($syllables as $index => $submittedSyllable) {
            $syllable = Syllable::firstOrCreate(['syllable' => $submittedSyllable['syllable']]);
            $syllableMapping = new SyllableMapping(['syllable_number' => $index - $syllableCount]);
            $syllableMapping->word_id = $word->id;
            $syllableMapping->syllable_id = $syllable->id;
            $syllableMapping->vowel_id = $submittedSyllable['vowel_id'];
            $syllableMapping->save();
        }
        return ['success' => 1, 'created_word' => $this->convertWord($word, $language_id)];
    }
    
    public function getWordRhymes($language_id, Request $request) {
        \DB::enableQueryLog();
        $this->validate($request, [
            'search' => 'required|alpha_spaces'
        ]);
        
        $wordsGiven = preg_split('/ +/', trim($request->input('search')), -1, PREG_SPLIT_NO_EMPTY);
        
        $wordsFound = Word::with('syllables', 'syllables.vowels')->ofLanguage($language_id)->whereIn('word', $wordsGiven)->get();
        if(count($wordsFound) === count($wordsGiven)) {
            $syllablesInWords = $wordsFound->map(function($word) {
                return $word->syllableMappings()->get();
            })->flatten(1);
            return array_merge($this->findRhymesForSyllables($syllablesInWords, $language_id), ['log' => \DB::getQueryLog()]);
        } else {
            $recognizedWords = $wordsFound->map(function($word) { return $word->word; })->all();
            $unrecognizedWords = array_diff($wordsGiven, $recognizedWords);
            return response()->json([
                'error' => 'Not all words have been recognized',
                'words_given' => $wordsGiven,
                'recognized_words' => $recognizedWords,
                'unrecognized_words' => $unrecognizedWords
            ]);
        }
    }

    private function findRhymesForSyllables($syllableSearch, $language_id) {
        $syllableConditions = $syllableSearch->map(function($syllableMapping) {
            return [['syllable_mappings.syllable_number', $syllableMapping->syllable_number],
                    ['syllable_mappings.vowel_id', $syllableMapping->vowel_id]];
        })->sortByDesc('syllable_number')->all();
        $syllableConditions = array_values($syllableConditions);

        $syllableSearch = $syllableSearch->sortByDesc('syllable_number');


        $query = Word::join('syllable_mappings', 'words.id', '=', 'syllable_mappings.word_id')
            ->join('syllables', 'syllables.id', '=', 'syllable_mappings.syllable_id')
            ->where('words.language_id', $language_id);

        $query->where(function($query) use ($syllableConditions) {
            foreach($syllableConditions as $condition) {
                $query->orWhere($condition);
            }
        });

        $controller = $this;
        $rhymingSyllablesOfWords = $query->get()->sortBy('word_id')->groupBy('word_id');
        $wordIds = $rhymingSyllablesOfWords->map(function($rhymingSyllables) {
            return $rhymingSyllables[0]['word_id'];
        })->toArray();
        $syllablesOfWords = Word::join('syllable_mappings', 'words.id', '=', 'syllable_mappings.word_id')
            ->join('syllables', 'syllables.id', '=', 'syllable_mappings.syllable_id')
            ->whereIn('words.id', $wordIds)
            ->get()
            ->groupBy('word_id');
        return collect($rhymingSyllablesOfWords)
            ->zip($syllablesOfWords)
            ->map(function($rhymingSyllablesAndWord) {
                $rhymingSyllables = $rhymingSyllablesAndWord[0];
                $word = $rhymingSyllables[0]['word'];
                $syllables = $rhymingSyllablesAndWord[1]->sortByDesc('syllable_number');
                $filledUpRhymingSyllables = $syllables->map(function($syllable) use($rhymingSyllables) {
                    return $rhymingSyllables->first(function($key, $rhymingSyllable) use ($syllable) {
                        return $rhymingSyllable['id'] == $syllable['id'];
                    });
                });
                return [
                    'word' => $word,
                    'rhymingSyllables' => $filledUpRhymingSyllables,
                    'syllables' => $syllables
                ];
            })
            ->map(function($rhyme) use ($syllableSearch, $controller) {
                $vocalRhymeQuality = $controller->determineEndingQuality($rhyme['syllables'], $rhyme['rhymingSyllables']);
                $lexicalSimilarityQuality = $controller->determineLexicalSimilarityQuality($rhyme['syllables'], $syllableSearch);
                $vocalPositionQuality = $controller->determineVocalPositionQuality($rhyme['syllables'], $syllableSearch);

                $qualityWeighting = [
                    [0.5, $vocalRhymeQuality],
                    [0.3, $lexicalSimilarityQuality],
                    [0.2, $vocalPositionQuality]
                ];

                $quality = collect($qualityWeighting)->reduce(function($accumulator, $weightAndValue) {
                    $weight = $weightAndValue[0];
                    $value = $weightAndValue[1];
                    return $accumulator + $weight * $value;
                }, 0);

                return [
                    'word' => $rhyme['word'],
                    'syllable_count' => count($rhyme['rhymingSyllables']),
                    'quality' => $quality
                ];
        })->sort(function($rhyme1, $rhyme2) {
            return $rhyme2['quality'] - $rhyme1['quality'];
        })->all();
    }

    private function determineEndingQuality($syllables, $rhymingSyllables) {
        $numSyllables = count($syllables);
        $quality = collect($syllables)
            ->zip($rhymingSyllables)
            ->reduce(function($acc, $syllables) use ($numSyllables) {
                $endingScore = $syllables[0]['syllable_number'] + $numSyllables + 1;
                return $acc + ($syllables[1] == null ? 0 : $endingScore);
            }, 0);
        return $quality / ($numSyllables * ($numSyllables + 1) / 2);
    }

    private function utf8StringToCharArray($str) {
        return preg_split('//u', $str, null, PREG_SPLIT_NO_EMPTY);
    }

    private function determineLexicalSimilarityQuality($rhymeSyllables, $searchSyllables) {
        $maxSyllables = max(count($rhymeSyllables), count($searchSyllables));
        $solver = new LcsSolver();

        $qualitySum = $rhymeSyllables->zip($searchSyllables)->map(function($rhymeAndSearchSyllable) use ($solver) {
            $rhymeSyllable = $rhymeAndSearchSyllable[0];
            $searchSyllable = $rhymeAndSearchSyllable[1];

            // make sure a string is passed, when rhyme doesn't have equal amount of syllables
            $a = $this->utf8StringToCharArray($searchSyllable['syllable']['syllable'] . ""); 
            $b = $this->utf8StringToCharArray($rhymeSyllable['syllable'] . "");

            $maxCharactersInSyllable = max(count($a), count($b));
            $lcs = $solver->longestCommonSubsequence($a, $b);
            return count($lcs) / ($maxCharactersInSyllable);
        })->reduce(function($sum, $v) {
            return $sum + $v;
        }, 0);
        return $qualitySum / $maxSyllables;
    }

    private function determineVocalPositionQuality($rhymeSyllables, $searchSyllables) {
        $maxSyllables = max(count($rhymeSyllables), count($searchSyllables));
        $qualitySum = $rhymeSyllables->zip($searchSyllables)->map(function($rhymeAndSearchSyllable) {
            $rhymeSyllable = $rhymeAndSearchSyllable[0];
            $searchSyllable = $rhymeAndSearchSyllable[1];

            $a = $this->determineVocalPosition($rhymeSyllable['syllable']);
            $b = $this->determineVocalPosition($searchSyllable['syllable']['syllable']);
            $diff = $a ^ $b;
            $numBitsSet = substr_count(base_convert($diff . "", 10, 2), "1");
            return (3 - $numBitsSet) / 3;
        })->reduce(function($sum, $v) {
            return $sum + $v;
        }, 0);
        return $qualitySum / $maxSyllables;
    }

    private function determineVocalPosition($syllable) {
        $vocals = ['a', 'e', 'i', 'o', 'u', 'y'];
        $lowerSyllable = strtolower($syllable);
        $length = mb_strlen($syllable);

        $vocalPositions = collect($vocals)->map(function($vocal) use ($lowerSyllable) {
            return strpos($lowerSyllable, $vocal);
        })->filter(function($position) {
            return $position !== false;
        });

        // test for start end and middle, because a syllable might just be of length 1 or 2
        return ($vocalPositions->contains(0)           ? VOCAL_POSITION_START  : 0)
             | ($vocalPositions->contains($length - 1) ? VOCAL_POSITION_END    : 0)
             | (count($vocalPositions->toArray()) > 2  ? VOCAL_POSITION_MIDDLE : 0);
    }
}
