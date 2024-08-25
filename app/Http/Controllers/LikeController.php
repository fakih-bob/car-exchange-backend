<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Auth;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function StoreFavorite($postId)
    {
        $user = Auth::user();
        $post = Post::findOrFail($postId);

        $existingFavorite = Like::where('user_id', $user->id)
                                     ->where('post_id', $postId)
                                     ->first();

        if ($existingFavorite) {
            return response()->json(['message' => 'You have already favorited this post'], 400);
        }

        Like::create([
            'user_id' => $user->id,
            'post_id' => $postId,
        ]);

        return response()->json(['message' => 'Post added to favorites'], 200);
    }

    // Remove post from favorites
    public function DeleteFavorite($postId)
    {
        $user = Auth::user();
        $favorite = Like::where('user_id', $user->id)
                            ->where('post_id', $postId)
                            ->first();

        if (!$favorite) {
            return response()->json(['message' => 'This post is not in your favorites'], 400);
        }

        $favorite->delete();

        return response()->json(['message' => 'Post removed from favorites'], 200);
    }

    // Get user's favorite posts
    public function ListFavorites()
    {
        $user = Auth::user();
        $favorites = Like::where('user_id', $user->id)->with('post')->get();

        return response()->json($favorites, 200);
    }
}
