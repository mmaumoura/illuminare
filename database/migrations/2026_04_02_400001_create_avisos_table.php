<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('avisos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('type')->nullable();
            $table->text('content');
            $table->string('attachment_path')->nullable();
            $table->string('attachment_name')->nullable();
            $table->enum('priority', ['baixa', 'normal', 'alta', 'urgente'])->default('normal');
            $table->date('expires_at')->nullable();
            $table->boolean('is_pinned')->default(false);
            $table->timestamps();
        });

        Schema::create('aviso_recipient', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aviso_id')->constrained('avisos')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            $table->unique(['aviso_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aviso_recipient');
        Schema::dropIfExists('avisos');
    }
};
