<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubdistrictIdToMasterPostcodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_postcodes', function (Blueprint $table) {
            $table->unsignedInteger('subdistrict_id')->nullable()->after('district_id');

            $table->foreign('subdistrict_id')->references('id')->on('master_subdistricts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_postcodes', function (Blueprint $table) {
            $table->dropForeign(['subdistrict_id']);

            $table->dropColumn('subdistrict_id');
        });
    }
}
