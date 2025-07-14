<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->longText('message')->nullable();
            $table->longText('exception')->nullable();
            $table->dateTime('filed_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('logs');
    }
};
