<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('res_sheets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sheeting_id')->unsigned();
            $table->foreign('sheeting_id')->references('id')->on('sheetings')->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('sheet_id')->unsigned();
            $table->foreign('sheet_id')->references('id')->on('worksheets')->onDelete('cascade');
            $table->float('score',6,2)->nullable();
            $table->char('current_status')->nullable();
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
        Schema::drop('res_sheets');
    }
}
