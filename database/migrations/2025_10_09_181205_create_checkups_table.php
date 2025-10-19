<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Checkups table
        Schema::create('checkups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('staff_id'); // staff performing the checkup
            $table->unsignedBigInteger('course_information_id'); // batch scheduling

            $table->date('date');
            $table->text('notes')->nullable(); // general notes
            $table->timestamps();

            $table->foreign('admin_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('staff_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('course_information_id')->references('id')->on('course_information')->onDelete('cascade');
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
            $table->decimal('respiratory_rate', 4, 1)->nullable();
            $table->integer('bmi')->nullable();
            $table->timestamps();

            $table->foreign('checkup_id')->references('id')->on('checkups')->onDelete('cascade');
        });

        // Dental table
        Schema::create('dentals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('checkup_id');

            $table->string('dental_status')->nullable();
            $table->integer('cavities')->nullable();
            $table->integer('missing_teeth')->nullable();
            $table->boolean('gum_disease')->default(false);
            $table->boolean('oral_hygiene')->default(true);
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->foreign('checkup_id')->references('id')->on('checkups')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dental');
        Schema::dropIfExists('vitals');
        Schema::dropIfExists('checkups');
    }
};
