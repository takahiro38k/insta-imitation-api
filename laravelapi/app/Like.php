<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    /**
     * relation
     * User 1:N Like
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * relation
     * Post 1:N Like
     */
    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
