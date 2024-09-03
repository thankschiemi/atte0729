<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropBreaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('breaks');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 必要に応じて、downメソッドにテーブルを再作成するコードを記述することも可能です
        Schema::create('breaks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('date_id');
            $table->dateTime('start_break')->nullable();
            $table->dateTime('end_break')->nullable();
            $table->timestamps();

            $table->foreign('date_id')->references('id')->on('dates')->onDelete('cascade');
        });
    }
}
