<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePersona extends Migration
{

    public function up()
    {
        Schema::create('persona', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 300)
                ->nullable();
            $table->char('tipo', 1)
                ->default('A')
                ->nullable();
                //A: ADMINISTRADOR, D: DISEÑADOR, C: CLIENTE
            $table->char('sexo', 1)
                ->nullable();
                //M: MASCULINO, F: FEMENINO        
            $table->char('dni', 8)
                ->nullable();
            $table->string('api_token', 500)
                ->nullable();
            $table->string('direccion', 120)
                ->nullable();
            $table->string('referencia', 120)
                ->nullable();
            $table->string('email', 120)
                ->nullable();
            $table->date('fecha_nac')
                ->nullable();
            $table->string('telefono', 9)
                ->nullable();
            $table->char('estado', 1)
                ->nullable();
                //A: ACTIVO, I: INACTIVO
            $table->integer('local_id')
                ->unsigned()
                ->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('persona');
    }
}
