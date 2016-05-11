<?php

namespace App\Http\Controllers;

use App\Language;

class LanguageController extends Controller {
    public function getLanguages() {
        return Language::all();
    }
    
    public function getLanguage($id) {
        return Language::findOrFail($id);
    }
}