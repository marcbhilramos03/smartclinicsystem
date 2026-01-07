<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up(): void
    {
        Schema::create('credential', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained('users','user_id')->onDelete('cascade');
            $table->string('profession')->nullable();
            $table->string('license_type')->nullable(); 
            $table->string('specialization')->nullable(); 
            $table->timestamps();
        });
    }

  
    public function down(): void
    {
        Schema::dropIfExists('credential');
    }
};
