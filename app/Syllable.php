<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Syllable extends Model 
{

    protected $fillable = [
        'start_index',
        'end_index',
        'vocal_id',
        'word_id'
    ];
}
