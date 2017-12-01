<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePathSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('path_sheets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ressheet_id')->unsigned();
            $table->foreign('ressheet_id')->references('id')->on('res_sheets')->onDelete('cascade');
            $table->text('path');
            $table->char('status')->nullable();
            $table->text('resrun')->nullable();
            $table->dateTime('send_date_time');
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
        Schema::drop('path_sheets');
    }
}
