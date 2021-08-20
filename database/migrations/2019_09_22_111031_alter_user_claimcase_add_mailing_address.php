<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUserClaimcaseAddMailingAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_claimcase', function (Blueprint $table) {
            $table->string('address_mailing_street_1',150)->nullable();
            $table->string('address_mailing_street_2',150)->nullable();
            $table->string('address_mailing_street_3',150)->nullable();
            $table->string('address_mailing_postcode',150)->nullable();
            $table->integer('address_mailing_district_id')->nullable();
            $table->integer('address_mailing_state_id')->nullable();
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
            $table->dropColumn('address_mailing_street_1');
            $table->dropColumn('address_mailing_street_2');
            $table->dropColumn('address_mailing_street_3');
            $table->dropColumn('address_mailing_postcode');
            $table->dropColumn('address_mailing_district_id');
            $table->dropColumn('address_mailing_state_id');
        });
    }
}