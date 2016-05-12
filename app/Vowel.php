<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vowel extends Model 
{

    protected $fillable = [
        'vowel'
    ];

    protected $timestamps = false;
    
    public function syllables() {
        return $this->hasMany(App\Syllable::class);
    }
}
