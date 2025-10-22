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
        Schema::create('credential', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained('users','user_id')->onDelete('cascade');
            $table->string('profession')->nullable(); // doctor, nurse, null for students
            $table->string('license_type')->nullable(); // for staff/doctors
            $table->string('specialization')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credential');
    }
};
