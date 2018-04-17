<?php

namespace App\Optymous\Database\Seeds;

use Illuminate\Database\Seeder;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table("users")->where('id', '>', 0)->delete();

		DB::table("users")->insert(array (
		  'id' => 5,
		  'name' => 'admin',
		  'email' => 'admin@digitalya.ro',
		  'created_at' => '2017-11-23 14:08:29',
		  'updated_at' => '2017-11-23 14:08:29',
		  'password' => bcrypt("asd123"),
		  'google2fa_secret' => app('pragmarx.google2fa')->generateSecretKey(32),
		  'user_type_id' => 8,
		));

		DB::table("users")->insert(array (
		  'id' => 6,
		  'name' => 'staff',
		  'email' => 'staff@digitalya.ro',
		  'created_at' => '2017-11-23 14:08:55',
		  'updated_at' => '2017-11-23 14:08:55',
		  'password' => bcrypt("asd123"),
		  'google2fa_secret' => app('pragmarx.google2fa')->generateSecretKey(32),
		  'user_type_id' => 9,
		));
    }
}
