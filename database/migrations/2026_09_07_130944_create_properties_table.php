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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->longText('description')->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');
            $table->string('country');
            $table->decimal('price', 15, 2);
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->string('parking')->nullable();
            $table->decimal('area', 10, 2)->nullable();
            $table->string('type'); // e.g., house, apartment, land
            $table->string('purpose'); // e.g., sell, rent
            $table->enum('inspection_status', ['Assigned', 'Scheduled', 'In Progress', 'Completed', 'Report Submitted'])->default('Assigned');
            $table->enum('verification_status', ['Pending', 'Under Review', 'Verified', 'Rejected'])->default('Pending');
            $table->enum('owner_type', ['admin', 'vendor'])->default('vendor');
            $table->boolean('is_verified')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamp('archived_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
