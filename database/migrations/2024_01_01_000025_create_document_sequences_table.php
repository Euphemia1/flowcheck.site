<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_sequences', function (Blueprint $table) {
            $table->uuid('organisation_id')->primary();
            $table->integer('pr_sequence')->default(1);
            $table->integer('po_sequence')->default(1);
            $table->integer('rfq_sequence')->default(1);
            $table->integer('grn_sequence')->default(1);
            $table->integer('invoice_sequence')->default(1);
            $table->integer('boq_sequence')->default(1);
            $table->integer('tender_sequence')->default(1);
            $table->integer('contract_sequence')->default(1);
            $table->timestamps();
            
            $table->foreign('organisation_id')->references('id')->on('organisations')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_sequences');
    }
};
