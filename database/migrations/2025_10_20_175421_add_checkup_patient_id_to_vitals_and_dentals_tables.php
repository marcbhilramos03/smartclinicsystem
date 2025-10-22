<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
  
        Schema::table('dentals', function (Blueprint $table) {
            $table->unsignedBigInteger('checkup_patient_id')->after('id');
            $table->foreign('checkup_patient_id')->references('id')->on('checkup_patients')->onDelete('cascade');
        });

        Schema::table('vitals', function (Blueprint $table) {
            $table->unsignedBigInteger('checkup_patient_id')->after('id');
            $table->foreign('checkup_patient_id')->references('id')->on('checkup_patients')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::table('dentals', function (Blueprint $table) {
            $table->dropForeign(['checkup_patient_id']);
            $table->dropColumn('checkup_patient_id');
        });

        Schema::table('vitals', function (Blueprint $table) {
            $table->dropForeign(['checkup_patient_id']);
            $table->dropColumn('checkup_patient_id');
        });
    }
};
