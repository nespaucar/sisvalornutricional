<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alimento', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('grupo_id')
                ->unsigned()
                ->nullable();
            $table->integer('numero')
                ->unsigned()
                ->nullable();
            $table->string('descripcion', 300)
                ->nullable();
            $table->string('codigo', 1)
                ->nullable();
            $table->decimal('energia_kcal', 10, 2)
                ->nullable();
            $table->decimal('energia_kJ', 10, 2)
                ->nullable();
            $table->decimal('agua', 10, 2)
                ->nullable();
            $table->decimal('proteina', 10, 2)
                ->nullable();
            $table->decimal('grasa', 10, 2)
                ->nullable();
            $table->decimal('carbohidrato_total', 10, 2)
                ->nullable();
            $table->decimal('carbohidrato_disponible', 10, 2)
                ->nullable();
            $table->decimal('fibra_dietaria', 10, 2)
                ->nullable();
            $table->decimal('ceniza', 10, 2)
                ->nullable();
            $table->decimal('calcio', 10, 2)
                ->nullable();
            $table->decimal('fosforo', 10, 2)
                ->nullable();
            $table->decimal('zinc', 10, 2)
                ->nullable();
            $table->decimal('hierro', 10, 2)
                ->nullable();
            $table->decimal('bcaroteno', 10, 2)
                ->nullable();
            $table->decimal('vitaminaA', 10, 2)
                ->nullable();
            $table->decimal('tiamina', 10, 2)
                ->nullable();
            $table->decimal('riboflavina', 10, 2)
                ->nullable();
            $table->decimal('niacina', 10, 2)
                ->nullable();
            $table->decimal('vitaminaC', 10, 2)
                ->nullable();
            $table->decimal('acido_folico', 10, 2)
                ->nullable();
            $table->decimal('sodio', 10, 2)
                ->nullable();
            $table->decimal('potasio', 10, 2)
                ->nullable();
            $table->integer('estado')
                ->unsigned()
                ->nullable(); // 1: ACTIVO, 2: INACTIVO
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
        Schema::dropIfExists('alimento');
    }
}
