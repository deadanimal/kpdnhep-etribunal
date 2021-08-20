<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdditionalDataToForm1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('form1', function (Blueprint $table) {
            $table->integer('case_year')->nullable();
            $table->integer('case_sequence')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('form1', function (Blueprint $table) {
            $table->dropColumn('case_year')->nullable();
            $table->dropColumn('case_sequence')->nullable();
        });
    }
}
