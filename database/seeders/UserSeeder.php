<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
	
    public function run()
    {
        $now = new DateTime;
		DB::table('usuario')->insert(
			array(
				'id'             => 1,
				'login'          => 'admin',
				'avatar'         => 'admin.jpg',
				'password'       => Hash::make('123'),
				'state'          => 'A',
				'persona_id'     => 1,
				'local_id'       => 1,
				'usertype_id'    => 1,
				'created_at'     => $now,
				'updated_at'     => $now
			)
		);
    }
}
