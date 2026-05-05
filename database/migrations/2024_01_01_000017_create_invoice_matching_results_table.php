<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_matching_results', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('invoice_id');
            $table->uuid('po_id')->nullable();
            $table->uuid('grn_id')->nullable();
            $table->decimal('qty_invoiced', 15, 2);
            $table->decimal('qty_ordered', 15, 2)->nullable();
            $table->decimal('qty_received', 15, 2)->nullable();
            $table->decimal('price_invoiced', 15, 2);
            $table->decimal('price_po', 15, 2)->nullable();
            $table->boolean('qty_match')->default(false);
            $table->boolean('price_match')->default(false);
            $table->text('notes')->nullable();
            $table->timestamp('checked_at')->useCurrent();
            
            $table->foreign('invoice_id')->references('id')->on('invoices')->cascadeOnDelete();
            $table->foreign('po_id')->references('id')->on('purchase_orders')->nullableOnDelete();
            $table->foreign('grn_id')->references('id')->on('goods_receipt_notes')->nullableOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_matching_results');
    }
};
