<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Registered; 
use Illuminate\Support\Facades\Auth;
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

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed'
        ]);

        $role = Role::find(1);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->role()->associate($role);
        $user->save();

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
          'message'=> 'confirmed successfully'
       ]) ;
    }
    public function verify(Request $request)
    {
        $user = User::findOrFail($request->id);

        if ($user->email_verified_at) {
            return Response()->json([
                'message'=> 'confirmed successfully'
             ]) ;
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

    }

    public function reset($token, Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed'
        ]);

        $validateToken = DB::table('password_resets')->where([
            'token' => $token,
            'email' => $request->email
        ])->first();

        if(!$validateToken){
            return response()->json([
                'Error' => 'Invalid Token'
            ]);
        }

        $user = User::where('email', $request->email)
        ->update(['password' => Hash::make($request->password)]);

        if($user){
            DB::table('password_resets')->where(['email'=> $request->email])->delete();

            return response()->json([
                'Success' => 'password updated successfully'
            ]);
        }
    }

    public function logout(){

        Auth::logout();
        return response()->json(['success'=>'you have logged out']);
    }
}
