<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('medical_histories', function (Blueprint $table) {
            $table->string('history_type', 100)->change();
        });
    }

    public function down(): void
    {
        Schema::table('medical_histories', function (Blueprint $table) {
            $table->enum('history_type', ['allergy', 'illness', 'vaccination'])->change();
        });
    }

};
