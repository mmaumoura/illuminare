<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sale_goal_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_goal_id')->constrained()->cascadeOnDelete();
            $table->date('data');
            $table->decimal('valor_realizado', 12, 2)->default(0);
            $table->integer('procedimentos_realizados')->default(0);
            $table->integer('pacientes_novos')->default(0);
            $table->text('notas')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
            $table->unique(['sale_goal_id', 'data']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sale_goal_entries');
    }
};
