<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeBlogwdPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blogwd_posts', function (Blueprint $table) {
            //
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('full_text');
            $table->string('image')->nullable();
            $table->boolean('image_show')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->boolean('published');
            $table->integer('viewed');
            $table->integer('created_by');
            $table->integer('modified_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blogwd_posts', function (Blueprint $table) {
            //
        });
    }
}
