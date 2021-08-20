<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFieldsToMasterCourtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_court', function (Blueprint $table) {
            $table->string('court_name_en', 255)->after('court_name');
            $table->boolean('is_magistrate')->default(0)->after('is_active');
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
            $table->dropColumn('court_name_en');
            $table->dropColumn('is_magistrate');
        });
    }
}
