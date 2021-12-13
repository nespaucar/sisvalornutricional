<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObservacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('observacion', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion', 6000)
                ->nullable();
            $table->char('estado', 1)
                ->nullable(); // P: PENDIENTE, E: EN PROGRESO, C: CANCELADO, T: TERMINADO, P: PRODUCCION
            $table->integer('encargado_id')
                ->unsigned()
                ->nullable();
            $table->date('fecha')
                ->nullable();
            $table->string('foto1', 1000)
                ->nullable();
            $table->string('foto2', 1000)
                ->nullable();
            $table->string('foto3', 1000)
                ->nullable();
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
        Schema::dropIfExists('observacion');
    }
}
