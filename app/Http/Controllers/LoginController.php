<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request){
        
        $validado = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if(Auth::attempt($validado)){
            $request->session()->regenerate();

            return redirect()->route('dashboardHome');
        }

        dd(Auth::attempt($validado));

    }
}
