<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnBlogwdPostsTable extends Migration
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
            $table->dropColumn('meta_title');
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
            $table->string('meta_title')->after('image_show')->nullable();
        });
    }
}
