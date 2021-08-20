<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_receipts', function(Blueprint $table)
        {
            $table->integer('id', true);
            $table->unsignedInteger('payment_id');
            $table->string('receipt_number');
            $table->timestamps();

            $table->foreign('payment_id')->references('payment_id')->on('payment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('log_receipts');
    }
}
