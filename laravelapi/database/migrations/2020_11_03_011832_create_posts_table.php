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

            // 画像のパスを保存
            $table->string('image_path')->nullable();

            // $table->string('title', 50); // max50文字
            // $table->unsignedTinyInteger('img'); # unsignedTinyInteger => 0 - 255
            // $table->unsignedTinyInteger('gender')->comment('1: 男性, 2: 女性, 3: その他');
            // $table->string('email', 255)->unique(); # ユニーク。重複を抑止。
            // $table->string('url', 2048)->nullable($value = true); # （デフォルトで）NULL値をカラムに挿入
            // $table->boolean('confirmed'); # mysqlのboolean型はtinyint(1)で、これは1bitを表す。1=true、0=false。

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
