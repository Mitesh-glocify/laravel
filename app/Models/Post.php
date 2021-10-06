<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function likes()
    {
        return $this->hasMany('PostLikes');
        $post = Post::where('id', 10)->first();
    }
}
