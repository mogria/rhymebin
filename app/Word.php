<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Word extends Model 
{

    protected $fillable = [
        'word',
        'language_id'
    ];
    
    public function language() {
        return $this->belongsTo(App\Language::class);
    }
    
    public function syllables() {
        return $this->hasMany(App\Syllable::class);
    }
    
    public function vowels() {
        return $this->hasManyThrough(App\Vowel::class, App\Syllable::class);
    }
}
