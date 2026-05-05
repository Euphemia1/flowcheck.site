<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('approval_workflows', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('organisation_id');
            $table->string('name');
            $table->uuid('department_id')->nullable();
            $table->decimal('min_amount', 15, 2)->nullable();
            $table->decimal('max_amount', 15, 2)->nullable();
            $table->json('steps'); // [{step: 1, role: "manager", user_id: null}, {step: 2, role: "cfo", user_id: "uuid"}]
            $table->timestamps();
            
            $table->foreign('organisation_id')->references('id')->on('organisations')->cascadeOnDelete();
            $table->foreign('department_id')->references('id')->on('departments')->nullableOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('approval_workflows');
    }
};
