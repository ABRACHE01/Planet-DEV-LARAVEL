<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Events\Registered; 
class AuthController extends Controller
{
    public function login(){

    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        $user->sendConfirmationEmail();

        return response()->json([
            'message' => 'User registered successfully. Please check your email for confirmation.'
        ], 201);
    }

    public function confirmEmail($code)
    {
        $user = User::where('confirmation_code', $code)->firstOrFail();

        $user->confirmEmail();

        return Response()->json([
          'message'=> 'confirmed succsefully'
       ]) ;
    }

    public function verify(Request $request)
    {
        $user = User::findOrFail($request->id);
    
        if ($user->email_verified_at) {
            return Response()->json([
                'message'=> 'confirmed succsefully'
             ]) ;
        }
    
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }
    
    }
        

    public function reset(){
        
    }
    public function logout(){
        
    }
}
