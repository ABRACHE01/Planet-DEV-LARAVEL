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
            'user'=> new UserResource($user)]);
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
            'user'=> new UserResource($user)]);
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
            'user'=> new UserResource($user)]);
    } 
    public function user(){
        $user = Auth::user();
        return new UserResource($user);
    }
    public function switchRole($id){
        $user = User::find($id);
        if($user->role->name=="user"){
            $user->role_id =3;
            $user->save();
        }
        else{
            $user->role_id=1;
            $user->save();
        }
        $user = User::find($id);
        return  response()->json([
            'success'=>'switched to '.$user->role->name,
            'user'=> new UserResource($user)
        ]);
    }
    public function users(){
        $users = User::whereDoesntHave('role', function($query) {
            $query->where('name', 'admin');
        })->get();
        return new UserCollection($users);
    }
    public function showOneUser($id){
        $user = User::find($id);
        return new UserResource($user);
    }
}
