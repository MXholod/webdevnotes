<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogwdCategoryablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogwd_categoryables', function (Blueprint $table) {
            $table->integer('blogwd_category_id');/* id from table blogwd_categories*/
            $table->integer('blogwd_categoryable_id');/*id field of a table of bound Model*/
            $table->string('blogwd_categoryable_type');/*string value of a bound Model*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogwd_categoryables');
    }
}
