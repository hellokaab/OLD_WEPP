<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReadyQueueExesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ready_queue_exes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('path_exam_id')->unsigned();
            $table->foreign('path_exam_id')->references('id')->on('path_exams')->onDelete('cascade');
            $table->string('file_type',10);
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
        Schema::drop('ready_queue_exes');
    }
}
