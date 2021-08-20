<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterBranchAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_branch_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('state_id');
            $table->string('branch_name');
            $table->text('address_my');
            $table->text('address_en');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('state_id')->references('state_id')->on('master_state');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_branch_addresses');
    }
}
