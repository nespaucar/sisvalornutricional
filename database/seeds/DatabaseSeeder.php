<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    
    public function run()
    {
        $this->call(LocalSeeder::class);
        $this->call(MenuoptionSeeder::class);
        $this->call(MenuoptioncategorySeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(PersonaSeeder::class);
        $this->call(UsertypeSeeder::class);        
        $this->call(UserSeeder::class);        
    }
}
