<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiveStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receive_stations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('base_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('approved_at')->nullable();
            $table->unsignedBigInteger('approve_token_id');
            $table->boolean('head')->default(false);

            $table->string('proposal_email')->nullable();
            $table->text('proposal_comment')->nullable();

            $table->string('name');
            $table->string('operator');
            $table->double('latitude');
            $table->double('longitude');
            $table->double('elevation')->nullable();
            $table->double('antenna_height')->nullable();
            $table->string('antenna_type')->nullable();
            $table->string('processing_system_type')->nullable();
            $table->integer('concurrent_receivers')->nullable();
            $table->json('reporting_to')->nullable();

            $table->foreign('approve_token_id')->references('id')->on('approve_tokens');
            $table->foreign('base_id')->references('id')->on('receive_stations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('launch_sites');
    }
}
