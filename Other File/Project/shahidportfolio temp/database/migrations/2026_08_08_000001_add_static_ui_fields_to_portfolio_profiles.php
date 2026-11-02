<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolio_profiles', function (Blueprint $table) {
            if (! Schema::hasColumn('portfolio_profiles', 'about_image')) {
                $table->string('about_image')->nullable()->after('hero_image');
            }

            if (! Schema::hasColumn('portfolio_profiles', 'about_extra_description')) {
                $table->text('about_extra_description')->nullable()->after('about_description');
            }
        });
    }

    public function down(): void
    {
        Schema::table('portfolio_profiles', function (Blueprint $table) {
            if (Schema::hasColumn('portfolio_profiles', 'about_extra_description')) {
                $table->dropColumn('about_extra_description');
            }

            if (Schema::hasColumn('portfolio_profiles', 'about_image')) {
                $table->dropColumn('about_image');
            }
        });
    }
};
