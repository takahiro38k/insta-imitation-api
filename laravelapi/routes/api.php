<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    // URLの先頭に auth を付与。
    'prefix' => 'auth'
], function () {
    // login - token取得
    Route::post('login', 'AuthController@login');
});

Route::group([
    // URLの先頭に auth を付与。
    'prefix' => 'auth',
    // 認証ガードを設定(トークンによる認証を行う)。
    // https://readouble.com/laravel/6.x/ja/api-authentication.html#protecting-routes
    'middleware' => 'auth:api'
], function () {
    // logout - token破棄
    Route::post('logout', 'AuthController@logout');
    // 【frontend未実装】token変更
    // Route::post('refresh', 'AuthController@refresh');
    // user情報取得
    Route::post('me', 'AuthController@me');
});

// api.php には Kernel.php の $middlewareGroups の 'api' が自動で反映される。
// 下記は自動反映と同じ意味なので不要。
// Route::group(["middleware" => "api"], function () {
// 新規アカウント作成
Route::post('/register', 'Auth\RegisterController@register');
// 【frontend未実装】password reset mail 送信
// Route::post("/password/email", "Auth\ForgotPasswordController@sendResetLinkEmail");
// 【frontend未実装】password reset
// Route::post("/password/reset/{token}", "Auth\ResetPasswordController@reset");
// 【frontend未実装】アカウントmail認証 => ※Userモデルのimplements設定もコメントアウトして無効化。
// Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
// 【frontend未実装】アカウントmail認証 mail再送信
// Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
// 【未実装】login userだけがアクセスできるページを設定
// Route::group(['middleware' => ['jwt.auth']], function () {
// });
// });

// リソースコントローラ
// https://readouble.com/laravel/6.x/ja/controllers.html#resource-controllers

Route::group([
    // 認証ガードを設定(トークンによる認証を行う)。
    // https://readouble.com/laravel/6.x/ja/api-authentication.html#protecting-routes
    'middleware' => 'auth:api'
], function () {
    // Route::apiResource('users', 'UserController'); // 不使用。各Controllerからrelationを使う。
    Route::apiResource('profiles', 'ProfileController')->only('index');
    Route::get('profiles/me', 'ProfileController@showMe');
    Route::put('profiles/me', 'ProfileController@updateMe');
    Route::apiResource('posts', 'PostController')->only('index', 'store');
    Route::apiResource('comments', 'CommentController')->only('index', 'store');
    Route::apiResource('likes', 'LikeController')->only(['index', 'store', 'destroy']);
});

// registerに合わせて実行するため、認証ガードのgroup外とする。
Route::post('profiles', 'ProfileController@store');

// S3 upload テスト
// Route::get('/s3', 'PostController@index');
// Route::post('/s3', 'PostController@store');
