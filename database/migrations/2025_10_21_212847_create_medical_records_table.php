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

            // Foreign keys
            $table->unsignedBigInteger('patient_id');  // patient
            $table->unsignedBigInteger('staff_id')->nullable();  // staff/doctor
            $table->unsignedBigInteger('admin_id')->nullable();  // admin who created/updated record
            $table->unsignedBigInteger('checkup_id')->nullable();
            $table->unsignedBigInteger('vitals_id')->nullable();
            $table->unsignedBigInteger('dentals_id')->nullable();
            $table->unsignedBigInteger('clinic_session_id')->nullable();
            $table->unsignedBigInteger('medical_history_id')->nullable();

            // Polymorphic relation
            $table->morphs('recordable'); // recordable_type + recordable_id, includes index

            $table->timestamps();

            // Foreign key constraints (make sure the PK of users table is actually 'user_id')
            $table->foreign('patient_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('staff_id')->references('user_id')->on('users')->onDelete('set null');
            $table->foreign('admin_id')->references('user_id')->on('users')->onDelete('set null');

            // Foreign keys for related tables
            $table->foreign('checkup_id')->references('id')->on('checkups')->onDelete('set null');
            $table->foreign('vitals_id')->references('id')->on('vitals')->onDelete('set null');
            $table->foreign('dentals_id')->references('id')->on('dentals')->onDelete('set null');
            $table->foreign('clinic_session_id')->references('id')->on('clinic_sessions')->onDelete('set null');
            $table->foreign('medical_history_id')->references('id')->on('medical_histories')->onDelete('set null');

            // ✅ Remove manual index for polymorphic relation, already added by morphs()
            // $table->index(['recordable_type', 'recordable_id']); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
