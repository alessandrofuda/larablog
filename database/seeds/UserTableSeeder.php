<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
        	'first_name' => 'Alessandro', 
        	'last_name' => 'Fuda', 
        	'slug' => 'alessandro_fuda', 
        	'email' => 'alessandro.fuda@gmail.com', 
        	'password' => \Hash::make('123456'),
        ]);

        User::create([
        	'first_name' => 'Paolo', 
        	'last_name' => 'Rossi', 
        	'slug' => 'paolo_rossi', 
        	'email' => 'investinelsole@gmail.com', 
        	'password' => \Hash::make('789101112'),
        ]);
    }
}
