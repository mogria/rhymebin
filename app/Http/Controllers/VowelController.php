<?php

namespace App\Http\Controllers;

use App\Vowel;

class VowelController extends Controller {
    public function getVowels($language_id) {
        return Vowel::with('vowelExamples')->get()->map(function($vowel) use($language_id) {
            return $this->convertVowel($vowel, $language_id);
        });
    }
    
    public function getVowel($language_id, $vowel_id) {
        $vowel = Vowel::with('vowelExamples')->where(['id' => $vowel_id])->first();
        return $this->convertVowel($vowel, $language_id);

    }
    
    public function convertVowel($vowel, $language_id) {
        return [
            'id' => $vowel->id,
            'vowel' => $vowel->vowel,
            'examples' => $vowel->vowelExamples()->ofLanguage($language_id)->get()->map(function($example) {
                return $example->word;
            })
        ];
    }
}
