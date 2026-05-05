<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('budget_lines', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('organisation_id');
            $table->uuid('department_id');
            $table->string('fiscal_year');
            $table->string('category');
            $table->decimal('allocated_amount', 15, 2);
            $table->decimal('committed_amount', 15, 2)->default(0);
            $table->decimal('spent_amount', 15, 2)->default(0);
            $table->timestamps();
            
            $table->foreign('organisation_id')->references('id')->on('organisations')->cascadeOnDelete();
            $table->foreign('department_id')->references('id')->on('departments')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budget_lines');
    }
};
