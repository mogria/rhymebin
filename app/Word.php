<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/*
+-------------+------------------+------+-----+---------+----------------+
| Field       | Type             | Null | Key | Default | Extra          |
+-------------+------------------+------+-----+---------+----------------+
| id          | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
| language_id | int(10) unsigned | NO   | MUL | NULL    |                |
| created_at  | timestamp        | YES  |     | NULL    |                |
| updated_at  | timestamp        | YES  |     | NULL    |                |
| word        | varchar(255)     | NO   |     | NULL    |                |
+-------------+------------------+------+-----+---------+----------------+
*/
class Word extends Model 
{

    protected $fillable = [
        'word',
        'language_id'
    ];
    
    /**
     * Scope a query to only include popular users.
     * @param Illuminate\Database\Eloquent\Builder $query
     * @param int $language_id
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfLanguage($query, $language_id) {
        return $query->where('language_id', $language_id);
    }
    
    public function language() {
        return $this->belongsTo(\App\Language::class);
    }
    
    public function syllables() {
        return $this->hasManyThrough(\App\Syllable::class, \App\SyllableMapping::class);
    }
}
