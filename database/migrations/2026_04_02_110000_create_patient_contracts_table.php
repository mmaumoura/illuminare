<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('contract_template_id')->nullable()->nullOnDelete()->constrained();
            $table->string('title');
            $table->string('type');
            $table->longText('content'); // rendered HTML with variables replaced
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_contracts');
    }
};
