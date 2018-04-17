<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCandidatesTableAddCampaignsNameColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table("candidates", function(Blueprint $table) {
            $table->integer("campaigns_total")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table("candidates", function(Blueprint $table) {
            $table->dropColumn("campaigns_total");
        });
    }
}
