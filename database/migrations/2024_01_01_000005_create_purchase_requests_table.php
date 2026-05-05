<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('organisation_id');
            $table->uuid('department_id')->nullable();
            $table->uuid('requested_by');
            $table->string('pr_number')->unique(); // PR-2025-00001
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('justification')->nullable();
            $table->enum('status', ['draft', 'submitted', 'under_review', 'approved', 'rejected', 'cancelled', 'converted_to_po'])->default('draft');
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal');
            $table->date('required_by_date')->nullable();
            $table->decimal('total_estimated_amount', 15, 2)->default(0);
            $table->uuid('current_approver_id')->nullable();
            $table->integer('approval_step')->default(0);
            $table->json('attachments')->nullable();
            $table->timestamps();
            
            $table->foreign('organisation_id')->references('id')->on('organisations')->cascadeOnDelete();
            $table->foreign('department_id')->references('id')->on('departments')->nullableOnDelete();
            $table->foreign('requested_by')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('current_approver_id')->references('id')->on('users')->nullableOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_requests');
    }
};
