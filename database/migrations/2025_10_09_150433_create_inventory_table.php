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
    Schema::create('inventory', function (Blueprint $table) {
        $table->id();
        $table->string('item_name'); // medicine or apparatus name
        $table->enum('type', ['medicine', 'apparatus']); // type
        $table->string('brand')->nullable();
        $table->string('unit')->nullable(); // e.g., tablet, ml, piece
        $table->integer('stock_quantity')->default(0); // current stock
        $table->date('expiry_date')->nullable(); // mainly for medicines
        $table->enum('status', ['available', 'damaged', 'used', 'expired'])->default('available');
        $table->text('notes')->nullable();
        $table->timestamps();
    });

    Schema::create('archived_inventory', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inventory_id'); // original inventory reference
            $table->string('item_name');
            $table->enum('type', ['medicine', 'apparatus']);
            $table->string('brand')->nullable();
            $table->string('unit')->nullable();
            $table->integer('quantity'); // number of units moved to archive
            $table->enum('status', ['used', 'expired', 'damaged']); // why archived
            $table->date('archived_date')->default(DB::raw('CURRENT_DATE'));
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('inventory_id')->references('id')->on('inventory')->onDelete('cascade');
        });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory');
        Schema::dropIfExists('archived_inventory');
    }
};
