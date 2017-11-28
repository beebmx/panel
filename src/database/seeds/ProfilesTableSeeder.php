<?php

use Illuminate\Database\Seeder;
use App\Profile;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profile::create(['name'				=> 'Administrador',
        				 'is_admin'			=> true,
        				 'has_panel'		=> true]);
        				 
		Profile::create(['name'				=> 'Editor',
        				 'is_admin'			=> false,
        				 'has_panel'		=> true]);
        				 
		Profile::create(['name'				=> 'Cliente',
        				 'is_admin'			=> false,
        				 'has_panel'		=> false]);
    }
}
