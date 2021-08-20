<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAppliedRepresentativeToAwardDisobeyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('award_disobey', function (Blueprint $table) {
            $table->string('applied_representative')->nullable()->after('applied_by');
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
            $table->dropColumn('applied_representative');
        });
    }
}
