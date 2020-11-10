<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->bigIncrements('id');

            // 外部キー制約
            // https://readouble.com/laravel/6.x/ja/migrations.html#foreign-key-constraints

            // 親テーブル(users)のidを参照する外部キー
            $table->unsignedBigInteger('user_id');
            // 外部キー制約を定義
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade') // 親テーブルの変更に連動
                ->onDelete('cascade'); // 親テーブルの削除に連動
            $table->string('nickname', 20); // max20文字
            $table->string('img_profile')->nullable();

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
        // 外部キーの制約を削除
        // https://readouble.com/laravel/6.x/ja/migrations.html#foreign-key-constraints
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('profiles');
    }
}
