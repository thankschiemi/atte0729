<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmployeeIdToMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('members', function (Blueprint $table) {
        // $table->string('employee_id')->unique(); // この行をコメントアウトまたは削除
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
{
    Schema::table('members', function (Blueprint $table) {
        if (Schema::hasColumn('members', 'employee_id')) {
            $table->dropColumn('employee_id'); // 逆マイグレーション用に社員IDを削除
        }
    });
}

}
