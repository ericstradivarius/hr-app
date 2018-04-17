<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationships2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
    Schema::create('candidate_files', function (Blueprint $table) {
        $table->increments('id');
        $table->unsignedInteger("candidate_id");
        $table->foreign("candidate_id")->references("id")->on("candidates")->onDelete("cascade")->onUpdate("cascade");
        $table->unsignedInteger("file_id");
        $table->foreign("file_id")->references("id")->on("files")->onDelete("cascade")->onUpdate("cascade");
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('candidate_files');
    }
}
