<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserCollection;

class UserController extends Controller
{
    public function updatePassword(request $request){ 
        $request->validate([
            'lastPassword'=>['required','min:8',function ($attribute, $value, $fail) {
                if (!Hash::check($value, auth()->user()->password)) {
                    $fail(__('The :attribute is incorrect.'));
                }
            }],
            'newPassword'=> 'required|min:8',
            'confirmPassword'=> 'required|same:newPassword'
        ]);
        $user = Auth::user();
        $user->password= Hash::make($request->newPassword);
        $user->save();
        return  response()->json([
            'success'=>' Password edited successfully',
            'user'=>[
                'id'=> $user->id,
                'name'=> $user->name,
                'email'=> $user->email,
                'role'=>$user->role->name,
            ]]);
    }
    public function updateName(request $request){
        $request->validate([
            'name'=>'required',
        ]);
        $user = Auth::user();
        $user->name= $request->name;
        $user->save();
        return  response()->json([
            'success'=>' Name edited successfully',
            'user'=>[
                'id'=> $user->id,
                'name'=> $user->name,
                'email'=> $user->email,
                'role'=>$user->role->name,
        ]]);
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
        return  response()->json([
            'success'=>' Email edited successfully',
            'user'=>[
                'id'=> $user->id,
                'name'=> $user->name,
                'email'=> $user->email,
                'role'=>$user->role->name,
        ]]);
    } 
    public function user(){
        $user = Auth::user();
        return  response()->json([
            'user'=>[
                'id'=> $user->id,
                'name'=> $user->name,
                'email'=> $user->email,
                'role'=>$user->role->name,
        ]]);
    }
    public function switchRole(User $user){
        if($user->role->name="user"){
            $user->role->name="author";
            $user->update();
        }
        else{
            $user->role->name="user";
            $user->update();
        }
    }
    public function users(){
        $users = User::where();
        return new UserCollection($users);
    }
    public function showOneUser(User $user){
        return new UserResource($user);
    }
}
