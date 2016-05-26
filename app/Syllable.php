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
    
    public function vowels() {
        return $this->belongsToMany(\App\Vowel::class, 'syllable_mappings');
    }
    
    public function words() {
        return $this->belongsToMany(\App\Word::class, 'syllable_mappings');
    }
}
