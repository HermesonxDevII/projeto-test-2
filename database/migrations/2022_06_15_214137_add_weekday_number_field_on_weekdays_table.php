<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('weekdays', function (Blueprint $table) {
            $table->integer('weekday_number')->after('short_name');
        });
    }

    public function down()
    {
        Schema::table('weekdays', function (Blueprint $table) {
            $table->dropColumn('weekday_number');
        });
    }
};
