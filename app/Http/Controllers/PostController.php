<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use Auth;
use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\Car;
use App\Models\Post;
use App\Models\Picture;

class PostController extends Controller
{

    public function index()
    {
        try {
            // Fetch all posts with their associated user, address, and car
            $posts = Post::with(['user', 'address', 'car','pictures'])->get()->all();
            
            // Return a successful JSON response with the posts data
            return response()->json($posts, 200);
        } catch (\Exception $e) {
            // Return a JSON response with an error message in case of failure
            return response()->json(['error' => 'Failed to retrieve posts', 'message' => $e->getMessage()], 500);
        }
    }
    
   public function StoreFullPost(PostRequest $request)
{
    $user = auth()->user();
    $userId = $user->id;

    // Create the Address
    $address = Address::create($request->input('address'));

    // Create the Car
    $car = Car::create($request->input('car'));

    // Create the Post
    $post = Post::create([
        'user_id' => $userId,
        'address_id' => $address->id,
        'car_id' => $car->id,
    ]);

    // Create the Pictures and associate them with the Post
    foreach ($request->input('pictures') as $pictureData) {
        Picture::create([
            'post_id' => $post->id,
            'Url' => $pictureData['Url'],
        ]);
    }

    return response()->json([
        'message' => 'Post with details created successfully!',
        'post' => $post->load(['address', 'car', 'pictures']),
    ], 201);
}
 
public function ListMyPosts()
{
    $user = Auth::user();
    // Get the posts for the authenticated user, including the car info
    $posts = Post::where('user_id', $user->id)->with('car')->get();
    
    // Map through the posts and extract car details
    $favoritesData = $posts->map(function($post) {
        return [
            'MyPostId'=>$post->id,
            'car' => [
                'id' => $post->car->id,
                'name' => $post->car->name,
                'category' => $post->car->category,
                'price' => $post->car->price,
                'Url' => $post->car->Url,
                'color' => $post->car->color,
                'brand' => $post->car->brand,
                'year' => $post->car->year,
                'description' => $post->car->description,
                'miles' => $post->car->miles,
            ],
        ];
    });

    return response()->json($favoritesData, 200);
}

public function getPostById($id)
    {
        // Find the post by ID
        $post = Post::with([ 'address', 'car','pictures'])->find($id);

        // Check if post exists
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        // Return the post data as JSON
        return response()->json($post);
    }


    public function DeletePost($id)
{
    $user = Auth::user();
    
    // Find the post by ID
    $post = Post::where('id', $id)->where('user_id', $user->id)->first();
    
    // Check if the post exists and belongs to the authenticated user
    if (!$post) {
        return response()->json(['message' => 'Post not found or you do not have permission to delete it'], 404);
    }

    // Delete the post
    $post->delete();

    return response()->json(['message' => 'Post deleted successfully'], 200);
}

public function updatePost(Request $request, $id)
{
    try {
        $user = auth()->user();
        $post = Post::with(['address', 'car', 'pictures'])->find($id);

        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        if ($post->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Update Address
        $post->address->update($request->input('address'));

        // Update Car
        $post->car->update($request->input('car'));

        
        $post->pictures()->delete();
        
        // Add new pictures
        foreach ($request->input('pictures') as $pictureData) {
            Picture::create([
                'post_id' => $post->id,
                'Url' => $pictureData['Url'],
            ]);
        }

        return response()->json([
            'message' => 'Post updated successfully!',
            'post' => $post->load(['address', 'car', 'pictures']),
        ], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to update post', 'message' => $e->getMessage()], 500);
    }
}



}


