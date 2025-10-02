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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('source_key')->index()->comment('guardian, newsapi, nytimes');
            $table->string('external_id')->nullable()->index();
            $table->string('title');
            $table->text('summary')->nullable();
            $table->text('body')->nullable();
            $table->string('url');
            $table->string('image_url')->nullable();
            $table->timestamp('published_at')->nullable()->index();
            $table->string('author')->nullable();
            $table->string('language', 10)->nullable();
            $table->json('raw_json')->nullable();
            $table->timestamps();

            $table->unique(['source_key', 'external_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
