<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $table = 'likes';

    // Define the attributes that are mass assignable
    protected $fillable = ['user_id', 'post_id'];

    // Define the relationship between Like and User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship between Like and Post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
