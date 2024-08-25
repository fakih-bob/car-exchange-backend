<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'address';

    // Define the attributes that are mass assignable
    protected $fillable = [ 'country', 'street','city','description'];

    public function post(){
        return $this->hasOne(Post::class);
    }
}
