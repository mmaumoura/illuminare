<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anamneses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('professional_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('token', 64)->unique();
            $table->string('signature_token', 64)->unique();
            $table->enum('status', ['rascunho', 'pendente_assinatura', 'completa'])->default('rascunho');
            $table->enum('filled_by', ['profissional', 'paciente'])->nullable();
            $table->timestamp('filled_at')->nullable();

            // Dados da Consulta
            $table->date('anamnesis_date');
            $table->text('chief_complaint')->nullable();
            $table->text('current_history')->nullable();
            $table->text('treatment_objective')->nullable();

            // Histórico Odontológico
            $table->string('last_dental_visit')->nullable();
            $table->string('brushing_frequency')->nullable();
            $table->boolean('uses_dental_floss')->nullable();
            $table->boolean('gum_bleeding')->nullable();
            $table->boolean('tooth_sensitivity')->nullable();
            $table->boolean('bruxism')->nullable();
            $table->boolean('tmj_pain')->nullable();
            $table->text('dental_treatments_history')->nullable();

            // Antecedentes Médicos
            $table->text('personal_history')->nullable();
            $table->text('family_history')->nullable();
            $table->text('chronic_diseases')->nullable();
            $table->boolean('has_diabetes')->nullable();
            $table->boolean('has_hypertension')->nullable();
            $table->boolean('has_heart_disease')->nullable();
            $table->boolean('has_blood_disorders')->nullable();
            $table->boolean('has_hepatitis')->nullable();
            $table->boolean('has_hiv')->nullable();
            $table->text('previous_surgeries')->nullable();
            $table->text('current_medications')->nullable();
            $table->text('allergies')->nullable();
            $table->boolean('anesthetic_allergy')->nullable();
            $table->boolean('latex_allergy')->nullable();
            $table->boolean('penicillin_allergy')->nullable();

            // Hábitos de Vida
            $table->boolean('smoker')->nullable();
            $table->string('smoker_details')->nullable();
            $table->boolean('alcohol')->nullable();
            $table->string('alcohol_details')->nullable();
            $table->boolean('exercises')->nullable();
            $table->string('exercise_details')->nullable();
            $table->string('sleep_quality')->nullable();
            $table->string('diet')->nullable();
            $table->string('water_intake')->nullable();

            // Informações Ginecológicas
            $table->string('menstrual_cycle')->nullable();
            $table->string('pregnancies')->nullable();
            $table->boolean('pregnant')->nullable();
            $table->boolean('breastfeeding')->nullable();

            // Avaliação Bucal
            $table->string('oral_hygiene_level')->nullable();
            $table->text('soft_tissue_exam')->nullable();
            $table->text('hard_tissue_exam')->nullable();
            $table->string('periodontal_status')->nullable();
            $table->text('occlusion')->nullable();

            // Observações & Assinatura
            $table->text('observations')->nullable();
            $table->longText('signature_data')->nullable();
            $table->timestamp('signed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anamneses');
    }
};
