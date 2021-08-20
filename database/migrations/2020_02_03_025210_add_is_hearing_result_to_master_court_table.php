<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsHearingResultToMasterCourtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_court', function (Blueprint $table) {
            $table->boolean('is_hearing_result')->after('is_magistrate')->default(0);
        });

        Schema::table('form4', function (Blueprint $table) {
            $table->unsignedInteger('letter_branch_address_id')->after('award_id')->nullable();
            $table->unsignedInteger('letter_court_id')->after('letter_branch_address_id')->nullable();

            $table->foreign('letter_branch_address_id')->references('id')->on('master_branch_addresses');
            $table->foreign('letter_court_id')->references('court_id')->on('master_court');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_court', function (Blueprint $table) {
            $table->dropColumn('is_hearing_result');
        });

        Schema::table('form4', function (Blueprint $table) {
            $table->dropForeign(['letter_branch_address_id']);
            $table->dropForeign(['letter_court_id']);

            $table->dropColumn('letter_branch_address_id');
            $table->dropColumn('letter_court_id');
        });
    }
}
