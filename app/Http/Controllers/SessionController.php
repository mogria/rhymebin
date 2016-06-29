<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller {
    
    public function postLogin(Request $request) {
        $token = Auth::attempt($request->only('name', 'password'));

        if (!$token)
        {
            return response()->json(['error' => 'Invalid Credentials'], 401);
        }
        
        return response()->json(['success' => 1, 'token' => $token]);
    }   

    
    public function postLogout(Request $request) {
        if(Auth::invalidate()) {
            return response()->json(['success' => 1]);
        }
        return response()->json(['error' => 'Could not invalidate token']);
    }
    
    public function postRefresh(Request $request) {
        return response()->json(['success' => 1, 'token' => Auth::refresh()]);
    }
    
}