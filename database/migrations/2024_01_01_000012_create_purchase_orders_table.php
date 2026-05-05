<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('organisation_id');
            $table->uuid('purchase_request_id')->nullable();
            $table->uuid('vendor_id');
            $table->string('po_number')->unique(); // PO-2025-00001
            $table->enum('status', ['draft', 'sent', 'acknowledged', 'partially_received', 'received', 'closed', 'cancelled'])->default('draft');
            $table->string('payment_terms')->nullable();
            $table->text('delivery_address')->nullable();
            $table->date('expected_delivery_date')->nullable();
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->uuid('approved_by')->nullable();
            $table->timestamps();
            
            $table->foreign('organisation_id')->references('id')->on('organisations')->cascadeOnDelete();
            $table->foreign('purchase_request_id')->references('id')->on('purchase_requests')->nullableOnDelete();
            $table->foreign('vendor_id')->references('id')->on('vendors')->cascadeOnDelete();
            $table->foreign('approved_by')->references('id')->on('users')->nullableOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
