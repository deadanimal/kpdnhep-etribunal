<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTransferBranchIdToClaimCaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('claim_case', function ($table) {
            $table->unsignedInteger('transfer_branch_id')->nullable()->after('branch_id');

            $table->foreign('transfer_branch_id')->references('branch_id')->on('master_branch');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('claim_case', function ($table) {
            $table->dropForeign(['transfer_branch_id']);

            $table->dropColumn('transfer_branch_id');
        });
    }
}
