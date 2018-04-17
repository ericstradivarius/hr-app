<?php

namespace App\Optymous\Database\Seeds;

use Illuminate\Database\Seeder;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class UserTypeTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table("user_types")->where('id', '>', 0)->delete();

		DB::table("user_types")->insert(array (
		  'id' => 8,
		  'name' => 'admin',
		  'created_at' => '2017-11-23 13:35:46',
		  'updated_at' => '2017-11-23 14:06:32',
		));

		DB::table("user_types")->insert(array (
		  'id' => 9,
		  'name' => 'staff',
		  'created_at' => '2017-11-23 14:06:24',
		  'updated_at' => '2017-11-23 14:06:24',
		));
    }
}
