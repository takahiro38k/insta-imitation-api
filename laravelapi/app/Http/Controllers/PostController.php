<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\User; // 追加
use Illuminate\Support\Facades\Auth; // 追加
use Storage; // 追加

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return $posts;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = new Post;
        // chromeのdev tools(Clockworkタブ)のlogに標示
        // clock($request->title);
        // clock($request->img);

        // reactで設定したFormDataインスタンス(uploadData)から、
        // "img" keyの値(格納した画像file)を取得。
        $image = $request->img;
        // $image を sns-photo-views-api バケットフォルダへアップロード
        // putFile()
        //   1st param  S3のdir名
        //   2nd param  保存するfile
        //   3rd param  ファイルの公開設定
        $path = Storage::disk('s3')->putFile('posts', $image, 'public');
        // アップロードした画像のフルパスを格納
        $post->img_post = Storage::disk('s3')->url($path);

        $post->user_id = Auth::id();
        $post->title = $request->title;
        // DBにfileのパスを保存
        $post->save();
        return $post;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
