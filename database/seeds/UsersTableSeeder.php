<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    		Model::unguard();

        DB::table('users')->insert([
        	'id' => '1168E654-4E14-4FD2-B75E-F81D30E9143B',
        	'account_id' => '5BC7C833-FE84-475B-B5C3-2A25B366069F',
        	'firstname' => 'Ryan',
        	'lastname' => 'Ginnow',
        	'username' => 'rginnow',
        	'password' => Hash::make('UP@12am!'),
        	'phone' => '3866270593',
        	'email' => 'ryan@revlift.com',
        	'description' => 'Revlift Developer',
        	'role' => 'Admin',
        	'created_at' => '2016-01-25'
        ]);

        Model::reguard();
    }
}
