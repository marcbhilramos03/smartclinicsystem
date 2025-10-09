<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('checkups', function (Blueprint $table) {
            $table->string('checkup_type')->default('vitals')->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('checkups', function (Blueprint $table) {
            $table->dropColumn('checkup_type');
        });
    }
};
