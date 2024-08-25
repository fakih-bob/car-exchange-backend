<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function UserData(){
        $user_id=Auth::user()->id;
        $user_info=User::where('id',$user_id)->first();
        return response()->json([
            'data'=>$user_info
        ]);
    }

    function UserUpdate(Request $request){
        $user=Auth::user();
        $user_id=$user->id;
        $customer = User::find($user_id);
        $customer->update($request->all());
        return response()->json([
            'status' => 'updated'
        ]);
    }

}
