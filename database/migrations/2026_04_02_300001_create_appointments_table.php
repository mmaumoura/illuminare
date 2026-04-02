<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('type');                               // Agendamento de Paciente, Agendamento Interno, Bloqueio de Agenda
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->foreignId('patient_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('professional_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('clinic_id')->nullable()->constrained()->nullOnDelete();
            $table->string('status')->default('Agendado');        // Agendado, Confirmado, Realizado, Cancelado, Falta
            $table->string('color', 20)->nullable()->default('#3B82F6');
            $table->text('observations')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('appointment_procedure', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('procedure_id')->constrained()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointment_procedure');
        Schema::dropIfExists('appointments');
    }
};
