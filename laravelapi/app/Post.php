<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * relation
     * User 1:N Post
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * relation
     * Post 1:N Comment
     */
    public function comment()
    {
        return $this->hasMany('App\Comment');
    }

    /**
     * relation
     * Post 1:N Like
     */
    public function like()
    {
        return $this->hasMany('App\Like');
    }
}
