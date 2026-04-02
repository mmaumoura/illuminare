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
        Schema::create('procedures', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->unsignedInteger('duration_minutes')->nullable();
            $table->unsignedInteger('sessions_recommended')->nullable();
            $table->unsignedInteger('sessions_interval_days')->nullable();
            $table->string('status')->default('Ativo'); // Ativo, Inativo
            $table->text('description')->nullable();
            $table->text('indications')->nullable();
            $table->text('contraindications')->nullable();
            $table->text('products_used')->nullable();
            $table->text('equipment_needed')->nullable();
            $table->text('pre_care')->nullable();
            $table->text('post_care')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procedures');
    }
};
