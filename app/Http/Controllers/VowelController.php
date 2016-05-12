<?php

namespace App\Http\Controllers;

use App\Vocal;

class VocalController extends Controller {
    public function getVocals() {
        return Vocal::all();
    }
    
    public function getVocal($id) {
        return Vocal::findOrFail($id);
    }
}
