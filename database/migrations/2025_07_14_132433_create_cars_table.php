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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('brand_id')->constrained()->onDelete('cascade');
            $table->string('model');
            $table->string('color');
            $table->float('locationLat', 10, 6);
            $table->float('locationLng', 10, 6);
            $table->float('kilometers', 10, 2);
            $table->float('price', 10, 2);
            $table->enum('engine', ['diesel', 'gasoline', 'hybrid', 'electric', 'lpg', 'cng']);
            $table->enum('state', ['new', 'used', 'refurbished']);
            $table->enum('transmission', ['manual', 'automatic']);
            $table->year('year');
            $table->float('fuel_consumption', 5, 2)->nullable();
            $table->text('description');
            $table->json('other_features')->nullable();
            $table->json('images')->nullable();
            $table->boolean('is_sold')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
