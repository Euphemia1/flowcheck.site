<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('goods_receipt_notes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('organisation_id');
            $table->uuid('purchase_order_id');
            $table->string('grn_number')->unique(); // GRN-2025-00001
            $table->uuid('received_by');
            $table->dateTime('received_at');
            $table->enum('status', ['draft', 'complete', 'partial'])->default('draft');
            $table->text('notes')->nullable();
            $table->json('attachments')->nullable();
            $table->timestamps();
            
            $table->foreign('organisation_id')->references('id')->on('organisations')->cascadeOnDelete();
            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders')->cascadeOnDelete();
            $table->foreign('received_by')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goods_receipt_notes');
    }
};
