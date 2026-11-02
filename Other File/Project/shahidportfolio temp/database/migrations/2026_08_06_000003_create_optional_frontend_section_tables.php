<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('portfolio_stats')) {
            Schema::create('portfolio_stats', function (Blueprint $table) {
                $table->id();
                $table->foreignId('portfolio_profile_id')->constrained()->cascadeOnDelete();
                $table->string('label');
                $table->string('description')->nullable();
                $table->string('icon_class');
                $table->unsignedInteger('value')->default(0);
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('is_active')->default(false);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('services')) {
            Schema::create('services', function (Blueprint $table) {
                $table->id();
                $table->foreignId('portfolio_profile_id')->constrained()->cascadeOnDelete();
                $table->string('title');
                $table->text('description');
                $table->string('icon_class');
                $table->string('details_url')->nullable();
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('is_active')->default(false);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('testimonials')) {
            Schema::create('testimonials', function (Blueprint $table) {
                $table->id();
                $table->foreignId('portfolio_profile_id')->constrained()->cascadeOnDelete();
                $table->string('name');
                $table->string('designation')->nullable();
                $table->text('message');
                $table->string('image')->nullable();
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('is_active')->default(false);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('services');
        Schema::dropIfExists('portfolio_stats');
    }
};
