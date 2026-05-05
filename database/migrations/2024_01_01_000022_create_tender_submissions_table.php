<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tender_submissions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tender_id');
            $table->uuid('vendor_id');
            $table->timestamp('submitted_at');
            $table->decimal('technical_score', 5, 2)->nullable();
            $table->decimal('financial_score', 5, 2)->nullable();
            $table->decimal('total_score', 5, 2)->nullable();
            $table->json('document_paths')->nullable();
            $table->boolean('is_awarded')->default(false);
            $table->timestamps();
            
            $table->foreign('tender_id')->references('id')->on('tenders')->cascadeOnDelete();
            $table->foreign('vendor_id')->references('id')->on('vendors')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tender_submissions');
    }
};
