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
        Schema::create('pre_registration', function (Blueprint $table) {
            $table->id();
            $table->string('study_plan');
            $table->string('guardian_name');
            $table->string('guardian_email');
            $table->string('guardian_phone');
            $table->string('zipcode');
            $table->string('province');
            $table->string('city');
            $table->string('district');
            $table->string('address');
            $table->string('complement');
            $table->string('japan_time');
            $table->string('children');
            $table->string('family_structure');
            $table->string('family_workers');
            $table->string('workload');
            $table->string('speaks_japanese');
            $table->string('studies_at_home');
            $table->string('will_return_to_home_country');
            $table->string('home_language');
            $table->string('student_name');
            $table->string('student_class');
            $table->string('student_language');
            $table->string('student_japan_arrival');
            $table->string('student_is_shy');
            $table->string('student_time_alone');
            $table->string('student_rotine');
            $table->string('student_extra_activities');
            $table->string('student_is_focused');
            $table->string('student_is_organized');
            $table->string('student_has_good_memory');
            $table->string('student_has_a_study_plan');
            $table->string('student_reviews_exams');
            $table->string('student_reads');
            $table->string('student_studies');
            $table->string('student_watches_tv');
            $table->string('student_uses_internet');
            $table->string('student_has_smartphone');
            $table->string('kokugo_grade');
            $table->string('shakai_grade');
            $table->string('sansuu_grade');
            $table->string('rika_grade');
            $table->string('eigo_grade');
            $table->string('student_has_difficult');
            $table->string('student_difficult_in_class');
            $table->string('student_frequency_in_support_class');
            $table->string('student_will_take_entrance_exams');
            $table->string('student_has_taken_online_classes');
            $table->string('guardian_expectations');
            $table->string('guardian_concerns')->nullable();
            $table->unsignedBigInteger('student_id')->nullable();

            $table->foreign('student_id')->references('id')->on('students');
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
        Schema::dropIfExists('pre_registration');
    }
};
