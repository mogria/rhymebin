<?php

namespace App\Http\Controllers;

use App\Word;

class WordController extends Controller {
    public function getWords() {
        return Word::all();
    }
    
    public function getWord($id) {
        return Word::findOrFail($id);
    }
    
    public function postWords() {
        $this->validate($request, [
            'word' => 'required|alpha|unique:words|between:1,255',
        ]);
    }
}
