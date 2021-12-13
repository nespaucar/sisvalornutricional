<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuarioPasswordResetTable extends Migration
{

    public function up()
    {
        Schema::create('usuario_password_resets', function (Blueprint $table) {
          $table->string('email');
          $table->string('token');
          $table->timestamp('created_at')
            ->nullable();
          $table->softDeletes();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('usuario_password_resets');
    }
}
