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
        Schema::table('monitoring_requests', function (Blueprint $table) {
            $table->foreignId('renter_id')->nullable()->constrained('users')->onDelete('set null')->after('property_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('monitoring_requests', function (Blueprint $table) {
            $table->dropForeign(['renter_id']);
            $table->dropColumn('renter_id');
        });
    }
};
