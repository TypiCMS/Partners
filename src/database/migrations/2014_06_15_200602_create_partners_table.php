<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePartnersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->boolean('homepage')->default(0);
            $table->integer('position')->unsigned()->default(1);
            $table->integer('image_id')->unsigned()->nullable();
            $table->json('status');
            $table->json('title');
            $table->json('slug');
            $table->json('website');
            $table->json('summary');
            $table->json('body');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('partners');
    }
}
