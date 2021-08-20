<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFieldsToInquiryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inquiry', function ($table) {
            $table->string('transaction_address')->nullable()->after('v1_id');
            $table->string('transaction_postcode')->nullable()->after('transaction_address');
            $table->unsignedInteger('transaction_district')->nullable()->after('transaction_postcode');
            $table->unsignedInteger('transaction_state')->nullable()->after('transaction_district');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inquiry', function ($table) {
            $table->dropColumn(['transaction_address','transaction_postcode','transaction_district','transaction_state']);
        });
    }
}
