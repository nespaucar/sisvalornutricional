<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMenuoption extends Migration
{

    public function up()
    {
        Schema::create('menuoption', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 60)
                ->nullable();
            $table->string('link', 120)
                ->nullable();
            $table->integer('order');
            $table->string('icon', 60)
                ->default('glyphicon glyphicon-expand')
                ->nullable();
            $table->integer('menuoptioncategory_id')
                ->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('menuoption');
    }
}
