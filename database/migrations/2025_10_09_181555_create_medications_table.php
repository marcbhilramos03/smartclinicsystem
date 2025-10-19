<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medications', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('session_id'); // links to clinic_sessions
    $table->unsignedBigInteger('inventory_id'); // links to inventory
    $table->string('dosage')->nullable();
    $table->string('duration')->nullable();
    $table->integer('stock_quantity')->default(1);
    $table->timestamps();

    $table->foreign('session_id')->references('id')->on('clinic_sessions')->onDelete('cascade');
    $table->foreign('inventory_id')->references('id')->on('inventory')->onDelete('restrict');
});

    }

    public function down(): void
    {
        Schema::dropIfExists('medications');
    }
};
