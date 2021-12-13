<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitacorasTable extends Migration
{

    public function up()
    {
        Schema::create('bitacora', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion', 600)
                ->nullable();
            $table->string('tabla', 60)
                ->nullable();
            $table->integer('tabla_id')
                ->unsigned()
                ->nullable();
            $table->integer('usuario_id')
                ->unsigned()
                ->nullable();
            $table->date('fecha')
                ->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bitacora');
    }
}
