<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organisations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('plan_id')->constrained();
            $table->enum('industry', ['mining', 'construction', 'manufacturing', 'other'])->default('other');
            $table->string('country', 2)->default('ZM');
            $table->string('currency', 3)->default('ZMW');
            $table->json('settings')->nullable(); // thresholds, approval rules, MFA enforcement
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organisations');
    }
};
