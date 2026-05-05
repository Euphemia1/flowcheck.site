<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('boq_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('boq_id');
            $table->string('item_code');
            $table->text('description');
            $table->string('unit');
            $table->decimal('quantity', 15, 2);
            $table->decimal('unit_rate', 15, 2);
            $table->decimal('amount', 15, 2);
            $table->timestamps();
            
            $table->foreign('boq_id')->references('id')->on('boqs')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('boq_items');
    }
};
