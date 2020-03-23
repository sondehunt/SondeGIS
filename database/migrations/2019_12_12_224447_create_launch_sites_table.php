<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaunchSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'launch_sites',
            function (Blueprint $table) {
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
                $table->integer('wmo_id')->nullable();
                $table->double('latitude')->nullable();
                $table->double('longitude')->nullable();
                $table->double('elevation')->nullable();
                $table->json('launch')->nullable();
            }
        );
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
