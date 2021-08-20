<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOpponentUserIdToForm2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('form2', function (Blueprint $table) {
            $table->unsignedInteger('opponent_user_id')->nullable()->after('form2_id');
            $table->foreign('opponent_user_id')->references('user_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('form2', function (Blueprint $table) {
            $table->dropForeign(['opponent_user_id']);
            $table->dropColumn(('opponent_user_id'));
        });
    }
}
