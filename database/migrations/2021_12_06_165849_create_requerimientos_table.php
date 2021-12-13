<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequerimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requerimiento', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion', 6000)
                ->nullable();
            $table->char('tipo', 1)
                ->nullable(); // U: URGENTE, M: MODERADO, N: NORMAL
            $table->integer('usuario_id')
                ->unsigned()
                ->nullable();
            $table->date('fecha_requerimiento')
                ->nullable();
            $table->char('estado', 1)
                ->nullable(); // P: PENDIENTE, E: EN PROGRESO, C: CANCELADO, T: TERMINADO, P: PRODUCCION
            $table->date('fecha_iniciado')
                ->nullable();
            $table->date('fecha_terminado')
                ->nullable();
            $table->date('fecha_produccion')
                ->nullable();
            $table->string('foto1', 1000)
                ->nullable();
            $table->string('foto2', 1000)
                ->nullable();
            $table->string('foto3', 1000)
                ->nullable();
            $table->integer('dias_estimados')
                ->unsigned()
                ->nullable(); // Tiempo de estimación para terminar el requrimiento
            $table->timestamps();
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
        Schema::dropIfExists('requerimiento');
    }
}
