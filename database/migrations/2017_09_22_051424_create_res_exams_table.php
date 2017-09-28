<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('res_exams', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('examing_id')->unsigned();
            $table->foreign('examing_id')->references('id')->on('examings')->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('exam_id')->unsigned();
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');
            $table->float('score',6,2);
            $table->char('current_status');
            $table->integer('sum_accep');
            $table->integer('sum_imp');
            $table->integer('sum_wrong');
            $table->integer('sum_comerror');
            $table->integer('sum_overtime');
            $table->integer('sum_overmem');
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
        Schema::drop('res_exams');
    }
}
