<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('email')->nullable();
            $table->string('logo')->nullable();
            $table->string('website')->nullable();
            $table->boolean('status');
            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users')->comment('User id who create the user!');
            $table->integer('last_modified_by')->unsigned();
            $table->foreign('last_modified_by')->references('id')->on('users')->comment('User id who update the user!');
            $table->timestamp('created_date');
            $table->timestamp('last_modified_date');
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
        Schema::drop('shop');
    }
}
