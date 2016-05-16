<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Word extends Model 
{

    protected $fillable = [
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
        return $this->belongsTo(App\Language::class);
    }
    
    public function syllables() {
        return $this->hasManyThough(App\Syllable::class, App\SyllableMapping::class);
    }
}
