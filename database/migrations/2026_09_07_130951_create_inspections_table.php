<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('properties')->onDelete('cascade');
            $table->foreignId('inspector_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->enum('status', ['Assigned', 'Scheduled', 'In Progress', 'Completed', 'Report Submitted'])->default('Assigned');
            $table->longText('notes')->nullable();
            $table->enum('recommendation', ['approve', 'reject', 'pending'])->default('pending');
            $table->timestamp('report_submitted_at')->nullable();
            $table->json('checklist')->nullable();
            $table->json('photos_documents')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};
