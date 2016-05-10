<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vocal extends Model 
{

    protected $fillable = [
        'vocal'
    ];

    protected $timestamps = false;
    
    public function syllables() {
        return $this->hasMany(App\Syllable::class);
    }
}
