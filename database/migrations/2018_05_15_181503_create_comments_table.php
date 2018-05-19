<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->text('contents');
            $table->integer('post_id');
            $table->integer('user_id');
            $table->integer('target_user_id')->nullable();
            $table->integer('target_comment_id')->nullable();
            $table->timestamps();
        });

        /*
         * 中间表
         * 用来储存用户点赞的记录
         * */
        Schema::create('comment_user_likes', function (Blueprint $table) {
            $table->integer('comment_id');
            $table->integer('user_id');
            $table->primary(['comment_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
        Schema::dropIfExists('comment_user_likes');
    }
}
