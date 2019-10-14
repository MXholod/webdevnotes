<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogwdStaticPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogwd_static_pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('meta_keywords')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('title');
            $table->string('description')->nullable();
            $table->text('full_text');
            $table->string('path');
            $table->tinyInteger('published')->default(0);
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
        Schema::dropIfExists('blogwd_static_pages');
    }
}
