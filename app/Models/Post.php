<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'post';

    // Define the attributes that are mass assignable
    protected $fillable = [ 'address_id', 'user_id','car_id'];

    public function address(){
        return $this->belongsTo(Address::class);
    }

    public function car(){
        return $this->belongsTo(Car::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function pictures(){
        return $this->hasMany(Picture::class);
    }
    public function Likes(){
        return $this->hasone(Like::class);
    }
}
