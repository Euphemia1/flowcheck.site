<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('approval_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('purchase_request_id');
            $table->integer('step_number');
            $table->uuid('approver_id');
            $table->enum('action', ['approved', 'rejected', 'returned', 'delegated']);
            $table->text('comments')->nullable();
            $table->timestamp('timestamp')->useCurrent();
            
            $table->foreign('purchase_request_id')->references('id')->on('purchase_requests')->cascadeOnDelete();
            $table->foreign('approver_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('approval_logs');
    }
};
