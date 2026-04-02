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
        Schema::table('clinics', function (Blueprint $table) {
            $table->string('cnpj', 18)->nullable()->after('name');
            $table->string('status', 20)->default('Ativa')->after('active');
            // Representante legal
            $table->string('rep_name')->nullable()->after('state');
            $table->string('rep_cpf', 14)->nullable()->after('rep_name');
            $table->string('rep_phone', 20)->nullable()->after('rep_cpf');
            $table->string('rep_email')->nullable()->after('rep_phone');
            // Contrato
            $table->date('contract_start')->nullable()->after('rep_email');
            $table->date('contract_end')->nullable()->after('contract_start');
            $table->text('contract_notes')->nullable()->after('contract_end');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clinics', function (Blueprint $table) {
            $table->dropColumn(['cnpj','status','rep_name','rep_cpf','rep_phone','rep_email','contract_start','contract_end','contract_notes']);
        });
    }
};
