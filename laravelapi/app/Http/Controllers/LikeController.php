<?php

namespace App\Http\Controllers;

use App\Like;
use Illuminate\Http\Request;
// 追加
use Illuminate\Support\Facades\Auth; // 追加
use Storage; // 追加

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // like一覧取得
        $likes = Like::all();

        return $likes;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $comment = new Like();
        $comment->user_id = Auth::id();
        $comment->post_id = $request->post;
        $comment->save();

        return $comment;
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Like $like)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Like $like)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // ! Front側で {data: { like } } として格納しているので、likeは連想配列として受け取る。
        // chromeのdev tools(Clockworkタブ)のlogに標示
        clock($request->like);
        clock($request->like['loginId']);
        clock($request->like['post']);

        $like = Like::where('user_id', $request->like['loginId'])
            ->where('post_id', $request->like['post']);
        $like->delete();
        // JSONレスポンス
        // response()->json()
        // https://readouble.com/laravel/6.x/ja/responses.html#json-responses
        return response()->json([
            'loginId' => $request->like['loginId'],
            'post' => $request->like['post'],
        ]);
    }
}
