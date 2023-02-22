<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request){
        // return response()->json(['message'=>'ok']);
        $request->validate([
            'email' => 'required|email',
            'password' =>
            [
                'required',
                Password::min(8)
                    ->letters()
            ],
        ]);
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            if (!$user) {
                throw ValidationException::withMessages([
                    'email' => ['The provided email is incorrect.']
                ]);  
            }elseif(!Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'password' => ['The provided password is incorrect.']
                ]);
               
            }
        }

        return response()->json(["api_token" => $user->createToken('api_token')->plainTextToken]); 
    }
    public function register(){
        
    }
    public function reset(){
        
    }
    public function logout(){
        
    }
}
