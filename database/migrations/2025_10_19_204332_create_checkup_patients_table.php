<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checkup_patients', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('checkup_id');
            $table->unsignedBigInteger('patient_id'); // refers to users.user_id

            $table->timestamps();

            $table->foreign('checkup_id')
                ->references('id')
                ->on('checkups')
                ->onDelete('cascade');

            $table->foreign('patient_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checkup_patients');
    }
};
