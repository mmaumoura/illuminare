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
        Schema::create('clinic_procedure', function (Blueprint $table) {
            $table->foreignId('clinic_id')->constrained()->onDelete('cascade');
            $table->foreignId('procedure_id')->constrained()->onDelete('cascade');
            $table->primary(['clinic_id', 'procedure_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinic_procedure');
    }
};
