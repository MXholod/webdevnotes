<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeBlogwdRoleUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blogwd_role_user', function (Blueprint $table) {
            //For Roles
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('blogwd_roles');
            //For Users
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('wdusers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blogwd_role_user', function (Blueprint $table) {
            //
        });
    }
}
