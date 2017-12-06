<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReadyQueueShesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ready_queue_shes', function (Blueprint $table) {
            $table->increments('id');
//            $table->integer('path_sheet_id')->unsigned();
//            $table->foreign('path_sheet_id')->references('id')->on('path_sheets')->onDelete('cascade');
            $table->integer('ressheet_id')->unsigned();
            $table->foreign('ressheet_id')->references('id')->on('res_sheets')->onDelete('cascade');
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
        Schema::drop('ready_queue_shes');
    }
}
