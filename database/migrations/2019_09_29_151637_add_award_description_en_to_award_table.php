<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAwardDescriptionEnToAwardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('award', function (Blueprint $table) {
            $table->text('award_description_en')->nullable()->after('award_description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('award', function (Blueprint $table) {
            $table->dropColumn('award_description_en');
        });
    }
}
