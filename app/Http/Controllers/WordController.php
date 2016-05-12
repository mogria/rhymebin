<?php

namespace App\Http\Controllers;

use App\Word;
use Illuminate\Http\Request;

class WordController extends Controller {
    public function getWords() {
        return Word::all();
    }
    
    public function getWord($id) {
        return Word::findOrFail($id);
    }
    
    public function postWords(Request $request) {
        $this->validate($request, [
            'word' => 'required|alpha|unique:words|between:1,255',
        ]);
    }
    
    public function getWordRhymes(Request $request) {
        $this->validate($request, [
            'language' => 'required|exists:languages',
            'search' => 'required|alpha_spaces'
        ]);
        
        $filteredSearch = preg_replace('/ +/', ' ', trim($request->input('search')));
        $wordsGiven = explode(" ", $filteredSearch);
        
        $wordsFound = Word::with('syllables', 'vowels')->whereIn('word', $wordsGiven)->get();
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
