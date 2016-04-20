<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
				Model::unguard();

        DB::table('accounts')->insert([
        	'id' => '5BC7C833-FE84-475B-B5C3-2A25B366069F',
        	'name' => 'Premier',
        	'owner' => 'Evan Buchert',
        	'contact_name' => 'Evan Buchert',
        	'contact_phone' => '208.949.9043',
        	'created_at' => '2015-01-25',
        	'created_by' => '1168E654-4E14-4FD2-B75E-F81D30E9143B'
        ]);

        Model::reguard();
    }
}
