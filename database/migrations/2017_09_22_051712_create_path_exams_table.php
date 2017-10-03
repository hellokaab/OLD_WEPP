<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePathExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('path_exams', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('resexam_id')->unsigned();
            $table->foreign('resexam_id')->references('id')->on('res_exams')->onDelete('cascade');
            $table->text('path');
            $table->char('status')->nullable();
            $table->text('resrun')->nullable();
            $table->dateTime('send_date_time');
            $table->float('time',6,5)->nullable();
            $table->float('memory',6,2)->nullable();
            $table->string('ip',30);
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
        Schema::drop('path_exams');
    }
}
