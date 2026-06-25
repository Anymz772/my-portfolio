<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('slug')->unique();
            $table->string('template')->default('modern');
            $table->boolean('is_published')->default(false);
            $table->boolean('maintenance_mode')->default(false);

            // Theme settings
            $table->string('primary_color')->default('#0f766e');
            $table->string('secondary_color')->default('#115e59');
            $table->string('accent_color')->default('#14b8a6');
            $table->enum('theme_mode', ['light', 'dark'])->default('light');

            // SEO settings
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->string('og_image')->nullable();

            // Analytics settings
            $table->string('google_analytics_id')->nullable();
            $table->text('custom_scripts')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
