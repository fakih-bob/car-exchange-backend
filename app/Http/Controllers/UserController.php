<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Car;
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

    function UserDelete() {
        $user = Auth::user();
        $user_id = $user->id;
        $posts = Post::where('user_id', $user_id)->get();
        foreach ($posts as $post) {
            Car::where('post_id', $post->id)->delete();
        }
        Post::where('user_id', $user_id)->delete();
        User::find($user_id)->delete();
    
        return response()->json([
            'status' => 'deleted'
        ]);
    }
    

}
