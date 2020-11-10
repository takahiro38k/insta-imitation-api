<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    /**
     * relation
     * User 1:1 Profile
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
