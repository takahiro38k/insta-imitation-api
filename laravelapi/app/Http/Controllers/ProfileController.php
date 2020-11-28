<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Http\Request;
use App\User; // 追加
use Illuminate\Support\Facades\Auth; // 追加
use Storage; // 追加

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // profile一覧取得
        $profiles = Profile::all();
        return $profiles;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // profile作成
        $profile = new Profile;
        $profile->user_id = $request->id;
        $profile->nickname = $request->nickname;
        $profile->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    // public function show(Profile $profile)
    public function show($id)
    {
        //
    }

    /**
     * 追加
     * login userのprofileを取得
     */
    public function showMe()
    {
        // profile取得

        // // postのidとログイン中のidが不一致ならエラーを返す。
        // // $idはstringなのでキャストして変換。
        // if (!((int) $id === Auth::id())) {
        //     // JSONレスポンス
        //     // response()->json()
        //     // https://readouble.com/laravel/6.x/ja/responses.html#json-responses
        //     return response()->json(['error' => 'id Unmatched'], 403);
        // }

        // $idは取得せず、下記のとおり自身のprofileを自動取得するように変更。

        // modelのrelation設定により、User model経由で処理。
        $profile = User::find(Auth::id())->profile;
        return $profile;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        //
    }

    /**
     * 追加
     * login userのprofileを更新
     */
    public function updateMe(Request $request, Profile $profile)
    {
        // chromeのdev tools(Clockworkタブ)のlogに標示
        // clock($request->nickname);
        // clock($request->img);

        $profile = User::find(Auth::id())->profile;
        // 画像があれば更新
        if ($request->img) {
            // reactで設定したFormDataインスタンス(uploadData)から、
            // "img" keyの値(格納した画像file)を取得。
            $image = $request->img;
            // $image を sns-photo-views-api バケットフォルダへアップロード
            // putFile()
            //   1st param  S3のdir名
            //   2nd param  保存するfile
            //   3rd param  ファイルの公開設定
            $path = Storage::disk('s3')->putFile('profiles', $image, 'public');
            // アップロードした画像のフルパスを格納
            $profile->img_profile = Storage::disk('s3')->url($path);
        }

        $profile->nickname = $request->nickname;
        // DBにfileのパスを保存
        $profile->save();
        return $profile;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
