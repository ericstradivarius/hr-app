<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationships extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
		Schema::table("users", function(Blueprint $table) {
			$table->unsignedInteger("user_type_id")->nullable()->default(null);
			$table->foreign("user_type_id", "user_type_id_foreign")->references("id")->on("user_types")->onDelete("cascade")->onUpdate("cascade");
		});

		Schema::table("user_permissions", function(Blueprint $table) {
			$table->dropColumn("user_type_id");
		});

		Schema::table("user_permissions", function(Blueprint $table) {
			$table->unsignedInteger("user_type_id")->nullable()->default(null)->after("id");
			$table->foreign("user_type_id", "user_permission_user_type_47_foreign")->references("id")->on("user_types")->onDelete("cascade")->onUpdate("cascade");
		});

		Schema::create("campaign_candidates_pivot", function (Blueprint $table) {
			$table->increments("id");
			$table->unsignedInteger("campaign_id");
			$table->foreign("campaign_id", "campaign_candidate_53_foreign_1")->references("id")->on("campaigns")->onDelete("cascade")->onUpdate("cascade");
			$table->unsignedInteger("candidate_id");
			$table->foreign("candidate_id", "campaign_candidate_53_foreign_2")->references("id")->on("candidates")->onDelete("cascade")->onUpdate("cascade");
			$table->timestamps();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
		Schema::table("users", function(Blueprint $table) {
			$table->dropForeign("user_type_id_foreign");
			$table->dropColumn("user_type_id");
		});

		Schema::table("user_permissions", function(Blueprint $table) {
			$table->dropForeign("user_permission_user_type_47_foreign");
			$table->dropColumn("user_type_id");
		});

		Schema::table("user_permissions", function(Blueprint $table) {
			$table->string("user_type_id")->nullable()->default(null)->after("id");
		});

		Schema::dropIfExists("campaign_candidate_pivot");
    }
}
