<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Vowel;

class Controller extends BaseController
{
    protected function convertVowel(Vowel $vowel, $language_id) {
        return [
            'id' => $vowel->id,
            'vowel' => $vowel->vowel,
            'examples' => $vowel->vowelExamples()->ofLanguage($language_id)->get()->map(function($example) {
                return $example->word;
            })
        ];
    }
    
}
