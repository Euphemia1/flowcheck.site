<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grn_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('grn_id');
            $table->uuid('po_item_id');
            $table->decimal('quantity_received', 15, 2);
            $table->enum('condition', ['good', 'damaged', 'rejected'])->default('good');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->foreign('grn_id')->references('id')->on('goods_receipt_notes')->cascadeOnDelete();
            $table->foreign('po_item_id')->references('id')->on('purchase_order_items')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grn_items');
    }
};
