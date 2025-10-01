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
        Schema::table('users', function (Blueprint $table) {
            $table->json('preferred_sources')->nullable()->after('password');
            $table->json('preferred_categories')->nullable()->after('preferred_sources');
            $table->json('preferred_authors')->nullable()->after('preferred_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['preferred_sources', 'preferred_categories', 'preferred_authors']);
        });
    }
};
