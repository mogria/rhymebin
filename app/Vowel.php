<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/*
+-------+------------------+------+-----+---------+----------------+
| Field | Type             | Null | Key | Default | Extra          |
+-------+------------------+------+-----+---------+----------------+
| id    | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
| vowel | varchar(255)     | NO   |     | NULL    |                |
+-------+------------------+------+-----+---------+----------------+
*/
class Vowel extends Model 
{

    protected $fillable = [
        'vowel'
    ];
    
    
    public $timestamps = false;
    
    
    public function syllables() {
        return $this->hasMany(\App\Syllable::class);
    }
    
    public function vowelExamples() {
        return $this->hasMany(\App\VowelExample::class);
    }
}
