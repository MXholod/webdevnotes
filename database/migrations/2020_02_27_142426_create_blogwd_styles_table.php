<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogwdStylesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogwd_styles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('path_css',255);
            $table->integer('styleable_id');/*id field of a table of bound Model*/
            $table->string('styleable_type');/*string value of a bound Model*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogwd_styles');
    }
}
