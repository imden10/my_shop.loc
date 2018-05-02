<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesLocTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories_loc', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cat_id');
            $table->char('lang',5);
            $table->char('name',255);
            $table->text('description');
            $table->char('meta_title',255);
            $table->char('meta_description',255);
            $table->char('meta_keys',255);
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
        Schema::drop('categories_loc');
    }
}
