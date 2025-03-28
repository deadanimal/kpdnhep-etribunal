<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPoscodeAtMasterDirectoryBranch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_directory_branch', function (Blueprint $table) {
            $table->string('postcode',20)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_directory_branch', function (Blueprint $table) {
            $table->integer('postcode',11)->change();
        });
    }
}
