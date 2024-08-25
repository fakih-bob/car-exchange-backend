<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $table = 'likes';

    // Define the attributes that are mass assignable
    protected $fillable = [ 'user_id', 'post_id'];

    public function Users(){
        return $this->belongsTo(User::class);
    }

    public function Posts(){
        return $this->belongsTo(Post::class);
    }
}