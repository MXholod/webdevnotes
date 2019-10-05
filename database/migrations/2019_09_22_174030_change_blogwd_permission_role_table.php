<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeBlogwdPermissionRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blogwd_permission_role', function (Blueprint $table) {
            //For Roles
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('blogwd_roles');
            //For Permissions
            $table->unsignedBigInteger('permission_id');
            $table->foreign('permission_id')->references('id')->on('blogwd_permissions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blogwd_permission_role', function (Blueprint $table) {
            //
        });
    }
}
