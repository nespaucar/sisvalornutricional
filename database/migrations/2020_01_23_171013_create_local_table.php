<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocalTable extends Migration
{

    public function up()
    {
        Schema::create('local', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion', 100)
                ->nullable();
            $table->string('logo', 80)
                ->nullable();
            $table->string('estado', 1)
                ->nullable();
                //A: ACTIVO, I: INACTIVO
            $table->timestamps();
            $table->softDeletes();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('local');
    }
}
