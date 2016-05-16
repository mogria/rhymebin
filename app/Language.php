<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model 
{

    protected $fillable = [
        'name'
    ];

    public $timestamps = false;
    
    public function words() {
        return $this->hasMany(\App\Word::class);
    }
    
    public function vowelExamples() {
        return $this->hasMany(\App\VowelExmaple::class);
    }
}
