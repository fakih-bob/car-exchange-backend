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

    // Fetch all favorites for the authenticated user with the related post, car, and address
    $favorites = Like::with(['post.car', 'post.address'])->where('user_id', $user->id)->get();

    // Map to structure the data as needed for the response
    $favoritesData = $favorites->map(function($favorite) {
        $post = $favorite->post;
        return [
            'post_id' => $post->id,
            'car' => [
                'id' => $post->car->id,
                'name' => $post->car->name,
                'category' => $post->car->category,
                'price' => $post->car->price,
                'Url' => $post->car->Url,
                'color'=>$post->car->color,
                'brand'=>$post->car->brand,
                'year'=>$post->car->year,
                'description'=>$post->car->description,
                'miles'=>$post->car->miles,
            ],
            'address' => [
                'id' => $post->address->id,
                'street' => $post->address->street,
                'city' => $post->address->city,
                'country'=>$post->address->country,
                'description'=>$post->address->description
            ],
        ];
    });

    return response()->json($favoritesData, 200);
}

    
}
