<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Word extends Model 
{

    protected $fillable = [
        'word',
        'language_id'
    ];
}
