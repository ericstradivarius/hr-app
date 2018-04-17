<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCandidatesTableMakeAvailableJobsInteger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table("campaigns", function(Blueprint $table) {
            $table->dropColumn("available_jobs");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table("campaigns", function(Blueprint $table) {
            $table->string("available_jobs")->nullable();
        });
    }
}
