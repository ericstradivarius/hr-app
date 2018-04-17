<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->increments('id');
			$table->string("name")->nullable()->default(null);
			$table->dateTime("start_date")->nullable()->default(null);
			$table->dateTime("end_date")->nullable()->default(null);
			$table->string("status")->nullable()->default(null);
			$table->string("available_jobs")->nullable()->default(null);
			$table->string("description")->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('campaigns');
    }
}
