<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sale_goals', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->enum('tipo', ['diaria', 'semanal', 'mensal', 'trimestral', 'anual'])->default('mensal');
            $table->decimal('meta_valor', 12, 2)->nullable();
            $table->integer('meta_procedimentos')->nullable();
            $table->integer('meta_pacientes_novos')->nullable();
            $table->date('periodo_inicio');
            $table->date('periodo_fim');
            $table->enum('status', ['ativa', 'concluida', 'cancelada'])->default('ativa');
            $table->foreignId('clinic_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('responsavel_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sale_goals');
    }
};
