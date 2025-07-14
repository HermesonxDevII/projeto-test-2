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
        Schema::rename('pre_registration', 'pre_registrations');

        Schema::table('pre_registrations', function (Blueprint $table) {
            $table->text('student_rotine')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('pre_registrations', 'pre_registration');

        Schema::table('pre_registration', function (Blueprint $table) {
            $table->string('student_rotine')->change();
        });
    }
};
