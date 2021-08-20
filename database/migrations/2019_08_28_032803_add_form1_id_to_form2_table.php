<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForm1IdToForm2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('form2', function (Blueprint $table) {
            $table->unsignedInteger('form1_id')->nullable()->after('form2_id');
            $table->foreign('form1_id')->references('form1_id')->on('form1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('form2', function (Blueprint $table) {
            $table->dropForeign(['form1_id']);
            $table->dropColumn(('form1_id'));
        });
    }
}
