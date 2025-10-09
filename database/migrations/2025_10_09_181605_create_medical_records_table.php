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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // patient
            $table->unsignedBigInteger('checkup_id')->nullable();
            $table->unsignedBigInteger('vitals_id')->nullable();
            $table->unsignedBigInteger('dental_id')->nullable();
            $table->unsignedBigInteger('clinic_session_id')->nullable();
            $table->unsignedBigInteger('medical_history_id')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('checkup_id')->references('id')->on('checkups')->onDelete('set null');
            $table->foreign('vitals_id')->references('id')->on('vitals')->onDelete('set null');
            $table->foreign('dental_id')->references('id')->on('dental')->onDelete('set null');
            $table->foreign('clinic_session_id')->references('id')->on('clinic_sessions')->onDelete('set null');
            $table->foreign('medical_history_id')->references('id')->on('medical_histories')->onDelete('set null');

            // Optional: add indexes for faster queries
            $table->index('user_id');
            $table->index('clinic_session_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
