<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_request_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('purchase_request_id');
            $table->text('description');
            $table->string('unit_of_measure');
            $table->decimal('quantity_requested', 15, 2);
            $table->decimal('unit_price_estimated', 15, 2)->default(0);
            $table->decimal('total_estimated', 15, 2)->default(0);
            $table->string('category')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->foreign('purchase_request_id')->references('id')->on('purchase_requests')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_request_items');
    }
};
