<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function updatePasssword(request $request,User $user){ 
        $request->validate([
            'lastPassword'=>'required|exists:users',
            'newPassword'=> 'required',
            'confirmPassword'=> 'required|same:newPassword'
        ]);
        $user->password= Hash::make($request->newPassword);
        $user->save();
        return  response()->json(['success'=>' password edited successfully']);
    }
    public function updateName(request $request,User $user){
        $request->validate([
            'name'=>'required',
        ]);
        $user->name= $request->name;
        $user->save();
        return  response()->json(['success'=>' password edited successfully']);
    }
    public function updateEmail(request $request,User $user){
        $request->validate([
            'email'=>'required',
        ]);
        $user->email= $request->email;
        $user->verified_at= null;
        $user->save();
        $user->sendConfirmationEmail();
        return  response()->json(['success'=>' Email edited successfully go and comfirme email']);
    } 
}
