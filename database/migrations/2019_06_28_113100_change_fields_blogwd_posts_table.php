<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFieldsBlogwdPostsTable extends Migration
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
            $table->integer('viewed')->nullable()->change();
            $table->integer('created_by')->nullable()->change();
            $table->integer('modified_by')->nullable()->change();
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
            $table->integer('viewed')->change();
            $table->integer('created_by')->change();
            $table->integer('modified_by')->change();
        });
    }
}
