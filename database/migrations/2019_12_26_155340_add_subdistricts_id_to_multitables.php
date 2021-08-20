<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubdistrictsIdToMultitables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_claimcase', function (Blueprint $table) {
            $table->unsignedInteger('subdistrict_id')->nullable()->after('district_id');
            $table->unsignedInteger('address_mailing_subdistrict_id')->nullable()->after('address_mailing_district_id');

            $table->foreign('subdistrict_id')->references('id')->on('master_subdistricts');
            $table->foreign('address_mailing_subdistrict_id')->references('id')->on('master_subdistricts');
        });

        Schema::table('user_public', function (Blueprint $table) {
            $table->unsignedInteger('address_subdistrict_id')->nullable()->after('address_district_id');
            $table->unsignedInteger('address_mailing_subdistrict_id')->nullable()->after('address_mailing_district_id');

            $table->foreign('address_subdistrict_id')->references('id')->on('master_subdistricts');
            $table->foreign('address_mailing_subdistrict_id')->references('id')->on('master_subdistricts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_claimcase', function (Blueprint $table) {
            $table->dropForeign(['subdistrict_id']);
            $table->dropForeign(['address_mailing_district_id']);

            $table->dropColumn('subdistrict_id');
            $table->dropColumn('address_mailing_district_id');
        });

        Schema::table('user_public', function (Blueprint $table) {
            $table->dropForeign(['address_subdistrict_id']);
            $table->dropForeign(['address_mailing_district_id']);

            $table->dropColumn('address_subdistrict_id');
            $table->dropColumn('address_mailing_district_id');

        });
    }
}
