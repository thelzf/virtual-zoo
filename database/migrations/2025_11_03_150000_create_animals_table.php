<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('species_id')->constrained('species')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('scientific_name');
            $table->json('alternate_names')->nullable();
            $table->string('habitat')->nullable();
            $table->text('habitat_description')->nullable();
            $table->decimal('life_expectancy_years', 5, 2)->nullable();
            $table->text('habits')->nullable();
            $table->text('curiosities')->nullable();
            $table->string('temperament')->nullable();
            $table->text('description')->nullable();
            $table->decimal('average_size_meters', 6, 2)->nullable();
            $table->decimal('average_weight_kilograms', 8, 2)->nullable();
            $table->string('diet')->nullable();
            $table->string('conservation_status')->nullable();
            $table->string('geographic_distribution')->nullable();
            $table->text('reproduction')->nullable();
            $table->text('social_behavior')->nullable();
            $table->string('featured_image_url')->nullable();
            $table->json('media_gallery')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
