<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogwdScriptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogwd_scripts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('path_js',255);
            $table->boolean('header_or_footer')->default(0);
            $table->integer('scriptable_id');/*id field of a table of bound Model*/
            $table->string('scriptable_type');/*string value of a bound Model*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogwd_scripts');
    }
}
