<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBreaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('breaks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id'); // member_idカラムの追加
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade'); // 外部キー制約
            $table->timestamp('start_break')->nullable();
            $table->timestamp('end_break')->nullable();
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
        Schema::dropIfExists('breaks');
    }
}
