<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEndorsementDateToAwardDisobeyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('award_disobey', function (Blueprint $table) {
            $table->date('endorsement_date')->nullable()->after('processed_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('award_disobey', function (Blueprint $table) {
            $table->dropColumn('endorsement_date');
        });
    }
}
