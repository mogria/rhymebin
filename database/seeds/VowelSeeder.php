<?php

use Illuminate\Database\Seeder;

class VowelSeeder extends Seeder {

    public function run() {

        $vowels = [
            ['i', ['fl*ee*ce'], ['s*i*be (7)']],
            ['i:', [], ['pf*ii*l', 'z*ii*t', 's*ii*be (v)']],
            ['y', [], ['ch*u*gelschriber']],
            ['y', [], ['s*ü*le']],
            ['ɪ', ['k*i*t']],
            ['e', ['b*e*t'], ['d*e*nä']],
            ['e:', [], ['t*ee*', 'gs*e*', 'm*e*h', 'd*ee*nä (v)']],
            ['ɛ', ['dr*e*ss'], ['h*e*rr']],
            ['æ', ['c*a*t'], ['g*ä*ll?']],
            ['a', ['itali*a*n'], ['h*a*fe', '*a*ffe', 'gh*a*lt']],
            ['a:', [], ['br*a*fe', 'schl*a*fe', 'gr*a*d']],
            ['ə', ['*a*fraid'], ['haf*e*', 'aff*e*']],
            ['ɑ', ['f*a*ther']],
            ['ɒ', ['l*o*t (british)', 'm*a*nne']],
            ['ɔ', ['th*ough*t']],
            ['ʌ', ['str*u*t']],
            ['o', ['g*o*at'], ['*o*bä', 'h*o*lä']],
            ['o:', [], ['ch*o*pf']],
            ['œ', [], ['bl*ö*ff']],
            ['ʊ', ['f*oo*t', 'c*ou*ld'], []],
            ['u', ['g*oo*se'], ['br*u*ch']],
            ['u:', [], ['b*u*ch (belly)', 'h*u*s', '*u*se']],
            ['ei̯', [], ['*ey*']],
            ['æi̯', [], ['n*äi*']],
            ['oi̯', [], ['h*oi*']],
            ['ou̯', [], ['m*ou*']],
            ['iə̯', [], ['l*ie*b', 'n*iä*']],
            ['uə̯', [], ['h*ue*t', 'k*ue*h']],
            ['yə̯', [], ['ch*ue*l', 'm*ue*d']],
            ['œu', [], ['*au*', 'st*au*']],
        ];

        foreach($vowels as $index => $vowel) {
            $vowel_id = $index + 1;
            $vowelText = $vowel[0];
            unset($vowel[0]);
            $examples = $vowel;
            DB::table('vowels')->insert(['id' => $vowel_id, 'vowel' => $vowelText]);
            $this->insertVowelExamples($vowel_id, $examples);
        }
    }
    
    public function insertVowelExamples($vowel_id, $examples) {
        foreach($examples as $language_id => $language_examples) {
            $this->insertVowelExamplesForLanguage($vowel_id, $language_id, $language_examples);
        }
    }
    
    public function insertVowelExamplesForLanguage($vowel_id, $language_id, $language_examples) {
        foreach($language_examples as $example) {
            $this->insertVowelExample($vowel_id, $language_id, $example);
        }
    }
    
    public function insertVowelExample($vowel_id, $language_id, $example) {
        DB::table('vowel_examples')->insert(
            ['vowel_id' => $vowel_id, 'language_id' => $language_id, 'word' => $example]
        );
    }
}
