<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('organisation_id');
            $table->uuid('boq_id')->nullable();
            $table->string('tender_number')->unique();
            $table->string('title');
            $table->enum('type', ['open', 'restricted', 'direct'])->default('open');
            $table->date('publication_date')->nullable();
            $table->date('closing_date');
            $table->enum('status', ['draft', 'published', 'closed', 'evaluated', 'awarded'])->default('draft');
            $table->uuid('created_by');
            $table->timestamps();
            
            $table->foreign('organisation_id')->references('id')->on('organisations')->cascadeOnDelete();
            $table->foreign('boq_id')->references('id')->on('boqs')->nullableOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenders');
    }
};
