<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/*
+-----------------+------------------+------+-----+---------+----------------+
| Field           | Type             | Null | Key | Default | Extra          |
+-----------------+------------------+------+-----+---------+----------------+
| id              | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
| syllable_id     | int(10) unsigned | NO   | MUL | NULL    |                |
| word_id         | int(10) unsigned | NO   | MUL | NULL    |                |
| syllable_number | int(11)          | NO   |     | NULL    |                |
| created_at      | timestamp        | YES  |     | NULL    |                |
| updated_at      | timestamp        | YES  |     | NULL    |                |
| vowel_id        | int(10) unsigned | NO   | MUL | NULL    |                |
+-----------------+------------------+------+-----+---------+----------------+
*/
class SyllableMapping extends Model  {
    protected $fillable = [
        'syllable_number'
    ];

    public function syllable() {
        return $this->belongsTo(\App\Syllable::class);
    }

    public function word() {
        return $this->belongsTo(\App\Word::class);
    }
}
