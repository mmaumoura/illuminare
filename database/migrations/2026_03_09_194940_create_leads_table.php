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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('nome_completo');
            $table->string('email')->nullable();
            $table->string('telefone')->nullable();
            $table->string('empresa')->nullable();
            $table->string('cargo')->nullable();
            $table->enum('status', ['novo', 'contatado', 'qualificado', 'convertido', 'perdido'])->default('novo');
            $table->enum('origem', ['site', 'indicacao', 'redes_sociais', 'evento', 'ligacao', 'email', 'outro'])->default('site');
            $table->text('observacoes')->nullable();
            $table->decimal('valor_estimado', 10, 2)->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('clinic_id')->nullable()->constrained('clinics')->nullOnDelete();
            $table->foreignId('crm_client_id')->nullable()->constrained('crm_clients')->nullOnDelete();
            $table->date('data_contato')->nullable();
            $table->timestamp('convertido_em')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
