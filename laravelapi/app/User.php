<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject; // 追加
use App\Notifications\CustomPasswordReset; // 追加
use App\Notifications\VerifyEmail; // 追加

/**
 * Illuminate\Foundation\Auth\User は Model を基底クラスに持つ。
 * よって Authenticatable を継承すれば祖先に Model が存在する。
 */
// class User extends Authenticatable
class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * JWT の subject claim となる識別子を取得する
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * キーバリュー値を返します, JWTに追加される custom claims を含む
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * パスワードリセット
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomPasswordReset($token));
    }

    /**
     * メールによるuser認証
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    // relation
    // https://readouble.com/laravel/6.x/ja/eloquent-relationships.html#one-to-one
    // https://readouble.com/laravel/6.x/ja/eloquent-relationships.html#one-to-many

    /**
     * relation
     * User 1:1 Profile
     */
    public function profile()
    {
        return $this->hasOne('App\Profile');
    }

    /**
     * relation
     * User 1:N Post
     */
    public function post()
    {
        return $this->hasMany('App\Post');
    }

    /**
     * relation
     * User 1:N Comment
     */
    public function comment()
    {
        return $this->hasMany('App\Comment');
    }

    /**
     * relation
     * User 1:N Like
     */
    public function like()
    {
        return $this->hasMany('App\Like');
    }
}
