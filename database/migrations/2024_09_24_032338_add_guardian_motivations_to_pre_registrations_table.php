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
            $table->text('guardian_motivations')->nullable()->after('guardian_concerns');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pre_registrations', function (Blueprint $table) {
            $table->dropColumn('guardian_motivations');
        });
    }
};
