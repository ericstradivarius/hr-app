<?php

namespace App\Optymous\Database\Seeds;

use Illuminate\Database\Seeder;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class CandidateTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        factory(\App\Optymous\candidate::class, 100)->create();
    }
}
