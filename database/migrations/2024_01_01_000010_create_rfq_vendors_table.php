<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rfq_vendors', function (Blueprint $table) {
            $table->uuid('rfq_id');
            $table->uuid('vendor_id');
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->string('response_file_path')->nullable();
            $table->timestamps();
            
            $table->primary(['rfq_id', 'vendor_id']);
            $table->foreign('rfq_id')->references('id')->on('rfqs')->cascadeOnDelete();
            $table->foreign('vendor_id')->references('id')->on('vendors')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rfq_vendors');
    }
};
