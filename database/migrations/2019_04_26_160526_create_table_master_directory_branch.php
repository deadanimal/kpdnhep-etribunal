<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMasterDirectoryBranch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_directory_branch', function (Blueprint $table) {
            $table->increments('directory_branch_id');
            $table->string('directory_branch_head', 100);
            $table->string('directory_branch_email', 100);
            $table->string('address_1', 100);
            $table->string('address_2', 100);
            $table->string('address_3', 100);
            $table->integer('postcode');
            $table->integer('district_id');
            $table->integer('state_id');
            $table->string('directory_branch_tel', 100);
            $table->string('directory_branch_faks', 100);
            $table->integer('is_active')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_directory_branch');
    }
}
