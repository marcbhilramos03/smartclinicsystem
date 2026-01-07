<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
    Schema::create('medical_histories', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('user_id');   
    $table->unsignedBigInteger('admin_id');  
    $table->string('history_type');
    $table->text('description');
    $table->date('date_recorded')->nullable();
    $table->timestamps();

    $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
    $table->foreign('admin_id')->references('user_id')->on('users')->onDelete('cascade');
});

    }

    
    public function down(): void
    {
        Schema::dropIfExists('medical_histories');
    }
};
