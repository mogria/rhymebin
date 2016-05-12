<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Syllable extends Model 
{

    protected $fillable = [
        'start_index',
        'end_index',
        'vowel_id',
        'word_id'
    ];
    
    public function vowel() {
        return $this->belongsTo(App\Vowel::class);
    }
    
    public function word() {
        return $this->belongsTo(App\Word::class);
    }
    
    public function getWordPart() {
        return substr($this->word->word, $this->start_index, $this->end_index - $this->start_index);
    }
}
