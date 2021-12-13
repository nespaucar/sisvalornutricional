<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocalSeeder extends Seeder
{

    public function run()
    {
        $now = new DateTime;

		DB::table('local')->insert(
			array(
				array(
					'id'          => 1,
					'descripcion' => 'LOCAL PRUEBA',
					'logo'        => NULL,
					'estado'      => 'A',
					'created_at'  => $now,
					'updated_at'  => $now
				)
			)
		);
    }
}
