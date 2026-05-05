<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rfqs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('organisation_id');
            $table->uuid('purchase_request_id')->nullable();
            $table->string('rfq_number')->unique(); // RFQ-2025-00001
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('deadline');
            $table->enum('status', ['draft', 'sent', 'closed', 'awarded'])->default('draft');
            $table->uuid('created_by');
            $table->timestamps();
            
            $table->foreign('organisation_id')->references('id')->on('organisations')->cascadeOnDelete();
            $table->foreign('purchase_request_id')->references('id')->on('purchase_requests')->nullableOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rfqs');
    }
};
