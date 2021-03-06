<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_files', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("campaign_id");
            $table->foreign("campaign_id")->references("id")->on("campaigns")->onDelete("cascade")->onUpdate("cascade");
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
    public function down()
    {
        Schema::dropIfExists('campaign_files');
    }
}
