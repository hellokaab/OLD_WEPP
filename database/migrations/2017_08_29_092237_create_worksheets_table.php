<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorksheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worksheets', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('sheetGroup_id')->unsigned();
            $table->foreign('sheetGroup_id')->references('id')->on('worksheet_groups')->onDelete('cascade');
            $table->string('sheet_name');
            $table->string('objective');
            $table->string('theory');
            $table->string('notation');
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
        Schema::drop('worksheets');
    }
}
