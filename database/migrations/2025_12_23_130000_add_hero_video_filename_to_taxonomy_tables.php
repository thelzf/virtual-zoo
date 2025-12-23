<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('phylums', function (Blueprint $table) {
            $table->string('hero_video_filename')->nullable()->after('description');
        });

        Schema::table('classes', function (Blueprint $table) {
            $table->string('hero_video_filename')->nullable()->after('description');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('hero_video_filename')->nullable()->after('description');
        });

        Schema::table('families', function (Blueprint $table) {
            $table->string('hero_video_filename')->nullable()->after('description');
        });

        Schema::table('genera', function (Blueprint $table) {
            $table->string('hero_video_filename')->nullable()->after('description');
        });

        Schema::table('species', function (Blueprint $table) {
            $table->string('hero_video_filename')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('phylums', function (Blueprint $table) {
            $table->dropColumn('hero_video_filename');
        });

        Schema::table('classes', function (Blueprint $table) {
            $table->dropColumn('hero_video_filename');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('hero_video_filename');
        });

        Schema::table('families', function (Blueprint $table) {
            $table->dropColumn('hero_video_filename');
        });

        Schema::table('genera', function (Blueprint $table) {
            $table->dropColumn('hero_video_filename');
        });

        Schema::table('species', function (Blueprint $table) {
            $table->dropColumn('hero_video_filename');
        });
    }
};
