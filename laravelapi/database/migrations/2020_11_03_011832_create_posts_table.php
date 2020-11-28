<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id');
            $table->string('title', 50); // max50文字
            $table->string('img_post')->nullable(); // S3のpathを格納

            $table->timestamps();

            // 外部キー制約
            // https://readouble.com/laravel/6.x/ja/migrations.html#foreign-key-constraints

            // 親テーブル(users)のidを参照する外部キー
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade') // 親テーブルの変更に連動
                ->onDelete('cascade'); // 親テーブルの削除に連動
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
        // Schema::table('posts', function (Blueprint $table) {
        //     $table->dropForeign(['user_id']);
        // });
        Schema::dropIfExists('posts');
    }
}
