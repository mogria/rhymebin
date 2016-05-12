<?php

namespace App\Http\Controllers;

use App\Vowel;

class VowelController extends Controller {
    public function getVowels() {
        return Vowel::all();
    }
    
    public function getVowel($id) {
        return Vowel::findOrFail($id);
    }
}
