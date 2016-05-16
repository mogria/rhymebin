<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Syllable extends Model 
{

    protected $fillable = [
        'syllable'
    ];
    
    public function vowel() {
        return $this->belongsTo(App\Vowel::class);
    }
    
    public function words() {
        return $this->hasManyThrough(App\Word::class, App\SyllableMapping::class);
    }
}
