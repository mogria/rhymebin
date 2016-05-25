<?php

namespace App\Http\Controllers;

use App\Word;
use App\Syllable;
use App\SyllableMapping;
use App\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WordController extends Controller {
    public function getWords($language_id) {
        return Language::findOrFail($language_id)->words;
    }
    
    public function getWord($language_id, $word_id) {
        // the language_id is not required, because the $word id is already 
        // unique
        return Word::findOrFail($word_id);
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
                if($index + 1 == $syllableCount && $syllable['end_index'] != strlen($submittedWord)) { // if this is the last syllable, end index must match word length
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
            $syllableMapping = new SyllableMapping(['syllable_number' => $index + 1]);
            $syllableMapping->word = $word;
            $syllableMapping->syllable = $syllable;
            $syllable = new Syllable($submittedSyllable);
            $syllable->save();
        }
        return ['success' => 1, 'created_word' => $word];
    }
    
    public function getWordRhymes($language_id, Request $request) {
        $this->validate($request, [
            'search' => 'required|alpha_spaces'
        ]);
        
        $wordsGiven = preg_split('/ +/', trim($request->input('search')), -1, PREG_SPLIT_NO_EMPTY);
        
        $wordsFound = Word::with('syllables', 'vowels')->ofLanguage($language_id)->whereIn('word', $wordsGiven)->get();
        if(count($wordsFound) === count($wordsGiven)) {
            $controller = $this;
            return $wordsFound->map(function($word) use ($controller) {
                $controller->findRhymesForWord($word);
            });
        } else {
            $recognizedWords = $wordsFound->map(function($word) { return $word->word; });
            $unrecognizedWords = array_diff($recognizedWords, $unrecognizedWords);
            return response()->json([
                'error' => 'Not all words have been recognized',
                'recognized_words' => $recognizedWords,
                'unrecognized_words' => $unrecognizedWords
            ]);
        }
    }

    private function findRhymesForWord($word) {
    }
}
