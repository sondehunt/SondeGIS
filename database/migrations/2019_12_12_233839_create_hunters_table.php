<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHuntersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hunters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('base_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('approve_token_id');
            $table->timestamp('approved_at')->nullable();

            $table->string('proposal_email')->nullable();
            $table->text('proposal_comment')->nullable();

            $table->string('name');
            $table->double('latitude');
            $table->double('longitude');
            $table->double('radius');
            $table->double('activity');
            $table->json('contact')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hunters');
    }
}
