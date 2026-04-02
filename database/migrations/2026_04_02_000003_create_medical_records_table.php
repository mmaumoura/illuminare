<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('professional_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('record_date');
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->foreignId('procedure_id')->nullable()->constrained()->nullOnDelete();
            $table->string('tooth_region')->nullable();
            $table->text('evolution');
            $table->text('diagnosis')->nullable();
            $table->text('treatment')->nullable();
            $table->text('materials')->nullable();
            $table->text('prescription')->nullable();
            $table->text('guidelines')->nullable();
            $table->date('next_session')->nullable();
            $table->text('treatment_plan')->nullable();
            $table->text('observations')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
