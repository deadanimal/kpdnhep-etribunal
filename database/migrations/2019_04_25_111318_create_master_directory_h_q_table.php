<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterDirectoryHQTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_directory_hq', function (Blueprint $table) {
            $table->increments('directory_hq_id');
            $table->enum('directory_hq_division', ['Chairman Office', 'Deputy Chairman Office','Assistant Chairman Office','Secretary','Administration And Finance Division','Registration Division','Management Hearing And Advice Division']);
            $table->string('directory_hq_name', 100);
             $table->enum('directory_hq_designation', ['Pengerusi','Pem. Setiausaha Pejabat','Timbalan Pengerusi','Peguam Kanan Persekutuan','Setiausaha','Pen. Peg. Tadbir','Pem. Tadbir (Kew)','Pem. Tadbir (P/O)','Pem. Penguatkuasa','Pen. Peg. Undang-Undang','Pembantu Am Pejabat','Pemandu Kenderaan']);
            $table->integer('directory_hq_ext');
            $table->string('directory_hq_email', 100);
            $table->integer('directory_hq_sort');
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
        Schema::dropIfExists('master_directory_hq');
    }
}
