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
        Schema::create('opportunities', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->decimal('valor', 10, 2)->nullable();
            $table->enum('estagio', ['prospeccao', 'qualificacao', 'proposta', 'negociacao', 'fechamento', 'ganho', 'perdido'])->default('prospeccao');
            $table->unsignedTinyInteger('probabilidade')->default(0);
            $table->date('data_fechamento_previsto')->nullable();
            $table->date('data_fechamento_real')->nullable();
            $table->foreignId('crm_client_id')->nullable()->constrained('crm_clients')->nullOnDelete();
            $table->foreignId('lead_id')->nullable()->constrained('leads')->nullOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('clinic_id')->nullable()->constrained('clinics')->nullOnDelete();
            $table->text('motivo_perda')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opportunities');
    }
};
