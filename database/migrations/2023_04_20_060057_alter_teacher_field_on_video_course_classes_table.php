<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('video_course_classes', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->dropColumn('teacher_id');

            $table->string('teacher')->nullable()->after('position');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('video_course_classes', function (Blueprint $table) {
            $table->dropColumn('teacher');
            
            $table->unsignedBigInteger('teacher_id')->nullable()->after('position');
            $table->foreign('teacher_id')->references('id')->on('users');
        });
    }
};
