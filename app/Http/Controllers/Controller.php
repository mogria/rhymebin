<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Vowel;

class Controller extends BaseController
{
    protected function convertVowel(Vowel $vowel, $language_id, $with_examples = false) {
        $data = [
            'id' => $vowel->id,
            'vowel' => $vowel->vowel,
        ];
        if($with_examples) {
            $vowelExamples = $vowel->vowelExamples()->ofLanguage($language_id)->get();
            $data['examples'] = $vowelExamples->map(function($example) {
                return $example->word;
            });
        }
        return $data;
    }
    
}
