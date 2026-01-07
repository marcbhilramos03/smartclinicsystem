<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checkups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('staff_id'); 
            $table->string('checkup_type'); 

            $table->date('date');
            $table->text('notes')->nullable(); 
            $table->timestamps();

            $table->foreign('admin_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('staff_id')->references('user_id')->on('users')->onDelete('cascade');
        });

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

       
        Schema::create('dentals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('checkup_id');
            $table->string('dental_status')->nullable();
            $table->enum('needs_treatment', ['yes', 'no'])->default('no');
            $table->string('treatment_type')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->foreign('checkup_id')->references('id')->on('checkups')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dentals');
        Schema::dropIfExists('vitals');
        Schema::dropIfExists('checkups');
    }
};
