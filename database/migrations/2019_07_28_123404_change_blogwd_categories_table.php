<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeBlogwdCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blogwd_categories', function (Blueprint $table) {
            //
             $table->string('meta_keywords')->after('slug')->nullable();
             $table->string('meta_description')->after('slug')->nullable();
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
            $table->dropColumn('meta_keywords');
            $table->dropColumn('meta_description');
        });
    }
}
