<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
+------------+------------------+------+-----+---------+----------------+
| Field      | Type             | Null | Key | Default | Extra          |
+------------+------------------+------+-----+---------+----------------+
| id         | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
| created_at | timestamp        | YES  |     | NULL    |                |
| updated_at | timestamp        | YES  |     | NULL    |                |
| syllable   | varchar(255)     | NO   | UNI | NULL    |                |
+------------+------------------+------+-----+---------+----------------+
*/

class Syllable extends Model 
{

    protected $fillable = [
        'syllable'
    ];
    
    public function vowel() {
        return $this->belongsTo(\App\Vowel::class);
    }
    
    public function words() {
        return $this->hasManyThrough(\App\Word::class, \App\SyllableMapping::class);
    }
}
