<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsLocTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_loc', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->char('lang',5);
            $table->char('name',255)->fillable();
            $table->text('description')->fillable();
            $table->char('meta_title',255)->fillable();
            $table->char('meta_description',255)->fillable();
            $table->char('meta_keys',255)->fillable();
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
        Schema::drop('products_loc');
    }
}
