<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends Controller {
    
    public function getUsers(Request $request) {
        return User::all();
    }
    
    public function getUser(Request $request, $id) {
        return User::findOrFail($id);
    }
    
    public function postUsers(Request $request) {
        $this->validate($request, [
            'name' => 'required|unique:users|between:3,30',
            'email' => 'required|unique:users|email|between:5,255',
            'password' => 'required|min:6'
        ]);
        
        $user = new User($request->all());
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return $user;
    }
    
    
}