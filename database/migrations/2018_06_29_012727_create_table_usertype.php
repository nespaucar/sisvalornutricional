<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUsertype extends Migration
{

    public function up()
    {
        Schema::create('usertype', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 500)
                ->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('usertype');
    }
}
