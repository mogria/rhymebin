<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/*
+-------+------------------+------+-----+---------+----------------+
| Field | Type             | Null | Key | Default | Extra          |
+-------+------------------+------+-----+---------+----------------+
| id    | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
| name  | varchar(255)     | NO   |     | NULL    |                |
+-------+------------------+------+-----+---------+----------------+
*/
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
