<?php

namespace App\Optymous\Database\Seeds;

use Illuminate\Database\Seeder;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class CampaignTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        factory(\App\Optymous\campaign::class, 100)->create();
    }
}
