<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function updatePassword(request $request){ 
        $request->validate([
            'lastPassword'=>'required|exists:users',
            'newPassword'=> 'required',
            'confirmPassword'=> 'required|same:newPassword'
        ]);
        $user->password= Hash::make($request->newPassword);
        $user->save();
        return  response()->json(['success'=>' password edited successfully']);
    }
    public function updateName(request $request){
        $request->validate([
            'name'=>'required',
        ]);
        $user->name= $request->name;
        $user->save();
        return  response()->json(['success'=>' password edited successfully']);
    }
    public function updateEmail(request $request){
        $request->validate([
            'email'=>'required',
        ]);
        $user = Auth::user();
        $user->email= $request->email;
        $user->email_verified_at=NULL;
        $user->update();
        $user->sendConfirmationEmail();
        return  response()->json(['success'=>' Email edited successfully go and comfirme email']);
    } 
}
