<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClaimCaseOpponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claim_case_opponents', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('claim_case_id')->nullable();
            $table->unsignedInteger('opponent_user_id')->nullable();
            $table->unsignedInteger('opponent_address_id')->nullable();
            $table->unsignedInteger('status_id')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('claim_case_id')->references('claim_case_id')->on('claim_case');
            $table->foreign('opponent_user_id')->references('user_id')->on('users');
            $table->foreign('opponent_address_id')->references('user_claimcase_id')->on('user_claimcase');
            $table->foreign('status_id')->references('id')->on('master_oppo_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('claim_case_opponents');
    }
}
