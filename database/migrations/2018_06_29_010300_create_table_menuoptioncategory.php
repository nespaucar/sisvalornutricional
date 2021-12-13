<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMenuoptioncategory extends Migration
{

    public function up()
    {
        Schema::create('menuoptioncategory', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)
                ->nullable();
            $table->integer('order');
            $table->string('icon', 60)
                ->default('fa fa-bank')
                ->nullable();
            $table->integer('menuoptioncategory_id')
                ->unsigned()
                ->nullable();
            $table->string('position', 1)
                ->nullable(); 
                // V = vertical , H = Horizontal
            $table->timestamps();
            $table->softDeletes();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('menuoptioncategory');
    }
}
