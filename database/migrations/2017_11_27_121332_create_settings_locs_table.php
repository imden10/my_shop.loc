<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsLocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_locs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('setting_id');
            $table->char('lang',5);
            $table->char('slogan',255);
            $table->char('address',255);
            $table->char('copy',255);
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
        Schema::drop('settings_locs');
    }
}
