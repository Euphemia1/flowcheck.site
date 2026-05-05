<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('organisation_id');
            $table->string('name');
            $table->decimal('budget_allocated', 15, 2)->default(0);
            $table->decimal('budget_used', 15, 2)->default(0);
            $table->uuid('manager_id')->nullable();
            $table->timestamps();
            
            $table->foreign('organisation_id')->references('id')->on('organisations')->cascadeOnDelete();
            $table->foreign('manager_id')->references('id')->on('users')->nullableOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
