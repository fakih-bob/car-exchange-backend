<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    use HasFactory;
    protected $table = 'pictures';

    // Define the attributes that are mass assignable
    protected $fillable = [ 'post_id', 'Url'];

    public function Post(){
        return $this->belongsTo(Post::class);
    }
}
