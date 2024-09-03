<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUserIdFromDatesTable extends Migration
{
    public function up()
    {
        Schema::table('dates', function (Blueprint $table) {
            // 外部キー制約が存在するかどうかを確認してから削除
            if (Schema::hasColumn('dates', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }

    public function down()
    {
        Schema::table('dates', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
