<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personal_information', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('user_id')->constrained('users','user_id')->onDelete('cascade');
            // Student/patient personal info
            $table->string('school_id')->unique();
            $table->string('course')->nullable();
            $table->string('grade_level');
            $table->string('emer_con_name')->nullable();
            $table->string('emer_con_rel')->nullable();
            $table->string('emer_con_phone')->nullable();
            $table->string('emer_con_address')->nullable();
      
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_information');
    }
};
