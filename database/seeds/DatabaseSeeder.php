<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(App\Optymous\Database\Seeds\UserTypeTableSeeder::class);
		$this->call(App\Optymous\Database\Seeds\UserTableSeeder::class);
		$this->call(App\Optymous\Database\Seeds\UserPermissionTableSeeder::class);
		$this->call(App\Optymous\Database\Seeds\campaignTableSeeder::class);
		$this->call(App\Optymous\Database\Seeds\candidateTableSeeder::class);
    }
}
