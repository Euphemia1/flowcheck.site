<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('organisation_id');
            $table->string('name');
            $table->string('contact_person')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('tax_pin')->nullable();
            $table->string('payment_terms')->nullable();
            $table->json('bank_details')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->decimal('performance_score', 5, 2)->default(0);
            $table->timestamps();
            
            $table->foreign('organisation_id')->references('id')->on('organisations')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
