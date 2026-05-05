<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('organisation_id');
            $table->uuid('user_id')->nullable();
            $table->string('action');
            $table->string('model_type')->nullable();
            $table->uuid('model_id')->nullable();
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('created_at')->useCurrent();
            
            $table->foreign('organisation_id')->references('id')->on('organisations')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->nullableOnDelete();
            
            $table->index('created_at');
            $table->index('model_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
