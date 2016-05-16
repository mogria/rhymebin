<?php

namespace App\Http\Controllers;

use App\Word;
use App\Language;
use Illuminate\Http\Request;

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
        $this->validate($request, [
            'word' => 'required|alpha|unique:words|between:1,255',
        ]);
    }
    
    public function getWordRhymes($language_id, Request $request) {
        $this->validate($request, [
            'search' => 'required|alpha_spaces'
        ]);
        
        $wordsGiven = preg_split('/ +/', trim($request->input('search')), -1, PREG_SPLIT_NO_EMPTY);
        
        $wordsFound = Word::with('syllables')->ofLanguage($language_id)->whereIn('word', $wordsGiven)->get();
        if(count($wordsFound) === count($wordsGiven)) {
            
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
}
