<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_lessons', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->enum('tipo', ['video', 'link', 'pdf', 'texto']);
            $table->string('arquivo_path')->nullable();
            $table->string('arquivo_nome')->nullable();
            $table->unsignedBigInteger('arquivo_tamanho')->nullable();
            $table->string('link_externo')->nullable();
            $table->longText('conteudo_texto')->nullable();
            $table->unsignedSmallInteger('duracao_minutos')->nullable();
            $table->unsignedSmallInteger('ordem')->default(0);
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_lessons');
    }
};
