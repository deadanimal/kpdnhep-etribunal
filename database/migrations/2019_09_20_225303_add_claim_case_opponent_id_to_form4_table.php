<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClaimCaseOpponentIdToForm4Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('form4', function (Blueprint $table) {
            $table->unsignedInteger('claim_case_opponent_id')->nullable()->after('claim_case_id');

            $table->foreign('claim_case_opponent_id')->references('id')->on('claim_case_opponents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('form4', function (Blueprint $table) {
            $table->dropForeign(['claim_case_opponent_id']);

            $table->dropColumn('claim_case_opponent_id');
        });
    }
}
