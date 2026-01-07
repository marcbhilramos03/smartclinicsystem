<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('patient_id');  
            $table->unsignedBigInteger('staff_id')->nullable(); 
            $table->unsignedBigInteger('admin_id')->nullable();  
            $table->unsignedBigInteger('checkup_id')->nullable();
            $table->unsignedBigInteger('vitals_id')->nullable();
            $table->unsignedBigInteger('dentals_id')->nullable();
            $table->unsignedBigInteger('clinic_session_id')->nullable();
            $table->unsignedBigInteger('medical_history_id')->nullable();
            $table->morphs('recordable');
            $table->timestamps();
            $table->foreign('patient_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('staff_id')->references('user_id')->on('users')->onDelete('set null');
            $table->foreign('admin_id')->references('user_id')->on('users')->onDelete('set null');
            $table->foreign('checkup_id')->references('id')->on('checkups')->onDelete('set null');
            $table->foreign('vitals_id')->references('id')->on('vitals')->onDelete('set null');
            $table->foreign('dentals_id')->references('id')->on('dentals')->onDelete('set null');
            $table->foreign('clinic_session_id')->references('id')->on('clinic_sessions')->onDelete('set null');
            $table->foreign('medical_history_id')->references('id')->on('medical_histories')->onDelete('set null');

           
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
