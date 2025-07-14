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
        Schema::table('pre_registrations', function (Blueprint $table) {
            $table->text('student_extra_activities')->change();
            $table->text('student_watches_tv')->change();
            $table->text('student_uses_internet')->change();
            $table->text('student_difficult_in_class')->change();
            $table->text('guardian_expectations')->change();
            $table->text('guardian_concerns')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pre_registration', function (Blueprint $table) {
            $table->string('student_extra_activities')->change();
            $table->string('student_watches_tv')->change();
            $table->string('student_uses_internet')->change();
            $table->string('student_difficult_in_class')->change();
            $table->string('guardian_expectations')->change();
            $table->string('guardian_concerns')->change();
        });
    }
};
