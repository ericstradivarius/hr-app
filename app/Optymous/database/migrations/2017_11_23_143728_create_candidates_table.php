<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidatesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('candidates', function (Blueprint $table) {
            $table->increments('id');
			$table->string("first_name")->nullable()->default(null);
			$table->string("last_name")->nullable()->default(null);
			$table->string("email")->nullable()->default(null);
			$table->string("phone")->nullable()->default(null);
			$table->string("status")->nullable()->default(null);
			$table->string("dob")->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('candidates');
    }
}
