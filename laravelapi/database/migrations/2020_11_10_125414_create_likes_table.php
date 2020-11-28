<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            // $table->bigIncrements('id'); // 複合キー設定のため不使用

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('post_id');

            $table->timestamps();

            // 外部キー制約
            // https://readouble.com/laravel/6.x/ja/migrations.html#foreign-key-constraints

            // 親テーブル(users)のidを参照する外部キー
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade') // 親テーブルの変更に連動
                ->onDelete('cascade'); // 親テーブルの削除に連動
            // 親テーブル(posts)のidを参照する外部キー
            $table->foreign('post_id')->references('id')->on('posts')
                ->onUpdate('cascade') // 親テーブルの変更に連動
                ->onDelete('cascade'); // 親テーブルの削除に連動

            // 複合キー
            // https://readouble.com/laravel/6.x/ja/migrations.html#creating-indexes

            // user_id と post_id の組み合わせにおいて、重複を抑止。
            $table->primary(['user_id', 'post_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // // 外部キーの制約を削除
        // // https://readouble.com/laravel/6.x/ja/migrations.html#foreign-key-constraints
        // Schema::table('likes', function (Blueprint $table) {
        //     $table->dropForeign(['user_id']);
        //     $table->dropForeign(['post_id']);
        // });
        Schema::dropIfExists('likes');
    }
}
