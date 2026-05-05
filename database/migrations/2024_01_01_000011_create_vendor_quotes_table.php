<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendor_quotes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('rfq_id');
            $table->uuid('vendor_id');
            $table->decimal('total_amount', 15, 2);
            $table->json('line_items')->nullable();
            $table->text('notes')->nullable();
            $table->date('validity_date')->nullable();
            $table->boolean('is_awarded')->default(false);
            $table->uuid('awarded_by')->nullable();
            $table->timestamp('awarded_at')->nullable();
            $table->timestamps();
            
            $table->foreign('rfq_id')->references('id')->on('rfqs')->cascadeOnDelete();
            $table->foreign('vendor_id')->references('id')->on('vendors')->cascadeOnDelete();
            $table->foreign('awarded_by')->references('id')->on('users')->nullableOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendor_quotes');
    }
};
