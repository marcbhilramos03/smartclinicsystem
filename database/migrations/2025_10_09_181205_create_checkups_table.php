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
       Schema::create('checkups', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('user_id'); // patient
    $table->unsignedBigInteger('staff_id'); // staff performing the checkup
    $table->date('date');
    $table->text('notes')->nullable();
    $table->timestamps();

    $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
    $table->foreign('staff_id')->references('user_id')->on('users')->onDelete('cascade');
});

        // Vitals table
        Schema::create('vitals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('checkup_id');
            $table->decimal('height', 5, 2)->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->string('blood_pressure')->nullable();
            $table->integer('pulse_rate')->nullable();
            $table->decimal('temperature', 4, 1)->nullable();
            $table->timestamps();

            $table->foreign('checkup_id')->references('id')->on('checkups')->onDelete('cascade');
        });

        // Dental table
        Schema::create('dental', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('checkup_id');
            $table->string('dental_status')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('checkup_id')->references('id')->on('checkups')->onDelete('cascade');
        });
    }   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dental');
        Schema::dropIfExists('vitals');
        Schema::dropIfExists('checkups');
    }
};
