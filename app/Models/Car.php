<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $table = 'cars';

    // Define the attributes that are mass assignable
    protected $fillable = ['category','brand','name', 'color','year','description','miles','Url','price'];

    public function PostCar(){
        return $this->belongsTo(Post::class);
    }
}
