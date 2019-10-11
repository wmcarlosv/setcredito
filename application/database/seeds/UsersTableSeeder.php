<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        	[
        		'name' => 'Carlos',
        		'last_name' => 'Vargas',
        		'email' => 'cvargas@frontuari.net',
        		'password' => bcrypt('Car2244los*'),
        		'role' => 'administrator'
        	]
        ]);
    }
}
