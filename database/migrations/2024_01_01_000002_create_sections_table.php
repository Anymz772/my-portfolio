<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')->constrained()->onDelete('cascade');
            $table->string('section_name'); // hero, about, skills, etc.
            $table->boolean('enabled')->default(true);
            $table->string('custom_title')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['portfolio_id', 'section_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_sections');
    }
};
