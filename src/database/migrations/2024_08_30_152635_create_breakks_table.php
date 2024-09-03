<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBreakksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('breakks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('date_id');
            $table->timestamp('start_break')->nullable();
            $table->timestamp('end_break')->nullable();
            $table->timestamps();

            // 外部キー制約を追加
            $table->foreign('date_id')->references('id')->on('dates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('breakks');
    }
}
