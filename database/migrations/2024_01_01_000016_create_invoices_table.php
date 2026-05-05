<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('organisation_id');
            $table->uuid('vendor_id');
            $table->uuid('purchase_order_id')->nullable();
            $table->string('invoice_number')->nullable(); // vendor's invoice number
            $table->string('internal_invoice_number')->unique();
            $table->date('invoice_date')->nullable();
            $table->date('due_date')->nullable();
            $table->decimal('total_amount', 15, 2);
            $table->enum('status', ['received', 'pending_matching', 'matched', 'discrepancy', 'approved_for_payment', 'paid', 'disputed'])->default('received');
            $table->enum('matching_status', ['unmatched', 'partial', 'matched', 'failed'])->default('unmatched');
            $table->string('file_path')->nullable();
            $table->timestamps();
            
            $table->foreign('organisation_id')->references('id')->on('organisations')->cascadeOnDelete();
            $table->foreign('vendor_id')->references('id')->on('vendors')->cascadeOnDelete();
            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders')->nullableOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
