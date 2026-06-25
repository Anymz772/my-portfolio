<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitor_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')->constrained()->onDelete('cascade');
            $table->string('session_id');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('referrer')->nullable();
            $table->string('path');
            $table->string('country')->nullable();
            $table->string('country_code', 10)->nullable();
            $table->string('region')->nullable();
            $table->string('city')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('browser')->nullable();
            $table->string('platform')->nullable();
            $table->string('device_type')->nullable(); // desktop, mobile, tablet
            $table->date('visited_at');
            $table->timestamps();

            $table->index(['portfolio_id', 'visited_at']);
            $table->index(['portfolio_id', 'country']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_stats');
    }
};
