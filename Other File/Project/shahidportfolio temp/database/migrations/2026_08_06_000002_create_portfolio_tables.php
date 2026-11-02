<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('portfolio_profiles')) {
            Schema::create('portfolio_profiles', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('title');
                $table->string('typed_items')->nullable();
                $table->string('profile_image')->nullable();
                $table->string('hero_image')->nullable();
                $table->text('about_summary')->nullable();
                $table->text('about_description')->nullable();
                $table->date('birthday')->nullable();
                $table->string('website')->nullable();
                $table->string('phone')->nullable();
                $table->string('city')->nullable();
                $table->unsignedSmallInteger('age')->nullable();
                $table->string('degree')->nullable();
                $table->string('email')->nullable();
                $table->string('freelance')->nullable();
                $table->string('skills_intro')->nullable();
                $table->text('resume_intro')->nullable();
                $table->text('portfolio_intro')->nullable();
                $table->text('contact_intro')->nullable();
                $table->text('map_embed_url')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('social_links')) {
            Schema::create('social_links', function (Blueprint $table) {
                $table->id();
                $table->foreignId('portfolio_profile_id')->constrained()->cascadeOnDelete();
                $table->string('name');
                $table->string('icon_class');
                $table->string('url');
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('skills')) {
            Schema::create('skills', function (Blueprint $table) {
                $table->id();
                $table->foreignId('portfolio_profile_id')->constrained()->cascadeOnDelete();
                $table->string('name');
                $table->unsignedTinyInteger('percentage')->default(0);
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('resume_sections')) {
            Schema::create('resume_sections', function (Blueprint $table) {
                $table->id();
                $table->foreignId('portfolio_profile_id')->constrained()->cascadeOnDelete();
                $table->string('name');
                $table->string('column')->default('left');
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('resume_items')) {
            Schema::create('resume_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('resume_section_id')->constrained()->cascadeOnDelete();
                $table->string('title');
                $table->string('period')->nullable();
                $table->string('subtitle')->nullable();
                $table->string('link_url')->nullable();
                $table->text('description')->nullable();
                $table->json('bullets')->nullable();
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('portfolio_categories')) {
            Schema::create('portfolio_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('portfolio_items')) {
            Schema::create('portfolio_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('portfolio_category_id')->nullable()->constrained()->nullOnDelete();
                $table->string('title');
                $table->text('description')->nullable();
                $table->string('image')->nullable();
                $table->string('details_url')->nullable();
                $table->boolean('is_mobile')->default(false);
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('contact_infos')) {
            Schema::create('contact_infos', function (Blueprint $table) {
                $table->id();
                $table->foreignId('portfolio_profile_id')->constrained()->cascadeOnDelete();
                $table->string('label');
                $table->string('value');
                $table->string('icon_class');
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_infos');
        Schema::dropIfExists('portfolio_items');
        Schema::dropIfExists('portfolio_categories');
        Schema::dropIfExists('resume_items');
        Schema::dropIfExists('resume_sections');
        Schema::dropIfExists('skills');
        Schema::dropIfExists('social_links');
        Schema::dropIfExists('portfolio_profiles');
    }
};
