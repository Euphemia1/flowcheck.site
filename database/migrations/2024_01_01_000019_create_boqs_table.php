<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('boqs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('organisation_id');
            $table->string('project_name');
            $table->string('boq_number')->unique();
            $table->text('description')->nullable();
            $table->decimal('total_estimated_value', 15, 2)->default(0);
            $table->enum('status', ['draft', 'approved', 'tendered', 'awarded'])->default('draft');
            $table->uuid('created_by');
            $table->json('attachments')->nullable();
            $table->timestamps();
            
            $table->foreign('organisation_id')->references('id')->on('organisations')->cascadeOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('boqs');
    }
};
