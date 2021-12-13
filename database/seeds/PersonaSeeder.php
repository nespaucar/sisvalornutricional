<?php

use Illuminate\Database\Seeder;

class PersonaSeeder extends Seeder
{
	
    public function run()
    {
    	$now = new DateTime;
        DB::table('persona')->insert(
        	array(
				array(
					'id'              => 1,
					'nombre'          => "Néstor Alexander Paucar Carhuatanta",
					'sexo'            => "M",
					'estado'          => "A",
					'fecha_nac'       => "1996-12-16",
					'email'           => "nespaucar@gmail.com",
					'telefono'        => "922179451",
					'dni'     		  => "73700450",
					'direccion'       => "Calle Circunvalación 150 - Chiclayo",
					'referencia'      => "Entre Balta y Chiclayo",
					'created_at'      => $now,
					'updated_at'      => $now
				)
			)
		);
    }
}
