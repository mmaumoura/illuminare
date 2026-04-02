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
        Schema::create('crm_clients', function (Blueprint $table) {
            $table->id();
            $table->string('nome_completo');
            $table->string('email')->unique()->nullable();
            $table->string('telefone');
            $table->date('data_nascimento')->nullable();
            $table->string('cpf', 14)->unique()->nullable();
            $table->enum('tipo', ['cliente', 'lead'])->default('cliente');
            $table->foreignId('clinic_id')->nullable()->constrained('clinics')->nullOnDelete();
            $table->string('cep', 9)->nullable();
            $table->string('logradouro')->nullable();
            $table->string('numero', 20)->nullable();
            $table->string('complemento')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('estado', 2)->nullable();
            $table->text('observacoes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crm_clients');
    }
};
