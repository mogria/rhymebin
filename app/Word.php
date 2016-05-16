<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Word extends Model 
{

    protected $fillable = [
    ];
    
    public function language() {
        return $this->belongsTo(App\Language::class);
    }
    
    public function syllables() {
        return $this->hasManyThough(App\Syllable::class, App\SyllableMapping::class);
    }
}
