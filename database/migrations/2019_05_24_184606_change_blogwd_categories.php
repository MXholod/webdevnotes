<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeBlogwdCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blogwd_categories', function (Blueprint $table) {
            //$table->increments('id');
            $table->integer('parent_id')->unsigned()->default(0);
            $table->string('title');
            $table->string('slug')->unique();  
            $table->text('description')->nullable(); 
            $table->tinyInteger('published')->nullable(); 
            $table->integer('created_by')->nullable();
            $table->integer('modified_by')->nullable(); 
            //$table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blogwd_categories', function (Blueprint $table) {
            //
        });
    }
}
