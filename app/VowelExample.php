<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class VowelExample extends Model {
    public $timestamps = false;
    
    
    protected $hidden = [
        'vowel_id',
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
    
    public function vowel() {
        return $this->belongsTo(\App\Vowel::class);
    }
    
    public function language() {
        return $this->belongsTo(\App\Language::class);
    }
}