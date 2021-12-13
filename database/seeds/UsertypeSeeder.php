<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsertypeSeeder extends Seeder
{
	
    public function run()
    {
        $now = new DateTime;

		DB::table('usertype')->insert(
			array(
				array(
					'id'         => 1,
					'nombre'     => 'ADMINISTRADOR PRINCIPAL',
					'created_at' => $now,
					'updated_at' => $now
				)
			)
		);
    }
}
