<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMemberIdToDatesTable extends Migration
{
    public function up()
    {
        Schema::table('dates', function (Blueprint $table) {
            if (!Schema::hasColumn('dates', 'member_id')) {
                $table->unsignedBigInteger('member_id')->after('id');
                $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('dates', function (Blueprint $table) {
            $table->dropForeign(['member_id']);
            $table->dropColumn('member_id');
        });
    }
}
