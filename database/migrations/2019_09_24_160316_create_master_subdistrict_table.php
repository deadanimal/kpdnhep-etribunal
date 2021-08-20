<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterSubdistrictTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_subdistricts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('ddsa_code')->index();
            $table->tinyInteger('level')->default(1)->index(); // 1 = mukim; 2 = bandar; 3 = pekan;
            $table->integer('district_id');
            $table->timestamp('active_at')->nullable();
            $table->timestamps();

            $table->foreign('district_id')->references('district_id')->on('master_district');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_subdistricts');
    }
}
