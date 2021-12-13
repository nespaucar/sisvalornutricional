<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePermission extends Migration
{

    public function up()
    {
        Schema::create('permission', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('usertype_id')
                ->unsigned()
                ->nullable();
            $table->integer('menuoption_id')
                ->unsigned()
                ->nullable();
            $table->timestamps();
            $table->softDeletes();            
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('permission');
    }
}
