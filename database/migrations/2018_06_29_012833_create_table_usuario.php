<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUsuario extends Migration
{

    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->increments('id');
            $table->string('login', 20)
                ->unique();
            $table->string('password');
            $table->string('avatar', 300)
                ->nullable();
            $table->char('state', 1)
                ->default('H')
                ->nullable();          
            $table->integer('usertype_id')
                ->unsigned()
                ->nullable();
            $table->integer('persona_id')
                ->unsigned()
                ->nullable();
            $table->integer('local_id')
                ->unsigned()
                ->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('usuario');
    }
}
