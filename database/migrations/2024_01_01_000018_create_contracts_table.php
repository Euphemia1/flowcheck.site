<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('organisation_id');
            $table->uuid('vendor_id');
            $table->string('contract_number')->unique();
            $table->string('title');
            $table->enum('type', ['fixed_price', 'rate_contract', 'framework'])->default('fixed_price');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('value', 15, 2)->nullable();
            $table->enum('status', ['draft', 'active', 'expiring_soon', 'expired', 'terminated'])->default('draft');
            $table->string('document_path')->nullable();
            $table->uuid('created_by');
            $table->timestamps();
            
            $table->foreign('organisation_id')->references('id')->on('organisations')->cascadeOnDelete();
            $table->foreign('vendor_id')->references('id')->on('vendors')->cascadeOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
