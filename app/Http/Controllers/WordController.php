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
            'name' => 'required|unique:users|between:3,30',
            'email' => 'required|unique:users|between:5,255',
            'password' => 'required|min:6'
        ]);
    }
}