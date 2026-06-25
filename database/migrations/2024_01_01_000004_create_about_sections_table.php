<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')->constrained()->onDelete('cascade');
            $table->text('bio');
            $table->string('profile_image')->nullable();
            $table->string('location');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->timestamps();
        });

        Schema::create('highlights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('about_section_id')->constrained()->onDelete('cascade');
            $table->string('text');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('highlights');
        Schema::dropIfExists('about_sections');
    }
};
