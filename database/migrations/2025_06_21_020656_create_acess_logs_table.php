<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('acess_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // quem fez o login
            $table->foreignId('student_id')->nullable()->constrained(); // null se não for responsável
            $table->string('role'); // admin, professor, responsavel
            $table->timestamp('accessed_at');
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acess_logs');
    }
};
