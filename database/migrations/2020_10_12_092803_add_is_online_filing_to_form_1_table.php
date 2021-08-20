<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsOnlineFilingToForm1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('form1', function (Blueprint $table) {
            $table->boolean('is_online_filing')->default(0)->after('is_printed');
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
            $table->dropColumn('is_online_filing');
        });
    }
}
