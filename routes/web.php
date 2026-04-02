<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AnamnesisController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AvisoController;
use App\Http\Controllers\BancoImagemController;
use App\Http\Controllers\SaleGoalController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\ContractTemplateController;
use App\Http\Controllers\PatientContractController;
use App\Http\Controllers\ClinicScopeController;
use App\Http\Controllers\CrmController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\PatientDocumentController;
use App\Http\Controllers\PatientPhotoController;
use App\Http\Controllers\ProcedureController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PublicAnamnesisController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\TreinamentoController;
use App\Http\Controllers\UniversidadeController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CrmClientController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ─────────────────────────────────────────────────────────────────────────────
// Perfil do usuário (Breeze)
// ─────────────────────────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/theme', [ThemeController::class, 'update'])->name('theme.update');
    Route::post('/theme/reset', [ThemeController::class, 'reset'])->name('theme.reset');

    Route::post('/clinic/switch', [ClinicScopeController::class, 'switch'])->name('clinic.switch');
});

// ─────────────────────────────────────────────────────────────────────────────
// Rotas protegidas por role
// ─────────────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'verified'])->group(function () {

    // Somente Administrador
    Route::middleware('role:administrador')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('usuarios', UserController::class)->parameters(['usuarios' => 'usuario']);
    });

    // Administrador + Gestor
    Route::middleware('role:administrador,gestor')->prefix('gestao')->name('gestao.')->group(function () {
        Route::resource('clinicas', ClinicController::class);
        Route::post('clinicas/{clinica}/documentos', [ClinicController::class, 'storeDocument'])->name('clinicas.documents.store');
        Route::put('clinicas/{clinica}/documentos/{document}', [ClinicController::class, 'updateDocument'])->name('clinicas.documents.update');
        Route::delete('clinicas/{clinica}/documentos/{document}', [ClinicController::class, 'destroyDocument'])->name('clinicas.documents.destroy');
        Route::resource('procedimentos', ProcedureController::class);
        Route::resource('contratos-modelos', ContractTemplateController::class)
            ->parameters(['contratos-modelos' => 'contratos_modelo']);
    });

    // Administrador + Gestor + Franqueado + Colaborador (pacientes)
    Route::middleware('role:administrador,gestor,franqueado,colaborador')->prefix('operacional')->name('operacional.')->group(function () {
        Route::get('pacientes/export', [PatientController::class, 'export'])->name('pacientes.export');
        Route::get('pacientes/import-template', [PatientController::class, 'importTemplate'])->name('pacientes.import-template');
        Route::post('pacientes/import', [PatientController::class, 'import'])->name('pacientes.import');
        Route::resource('pacientes', PatientController::class)->parameters(['pacientes' => 'paciente']);

        // Paciente — Documentos
        Route::post('pacientes/{paciente}/documentos', [PatientDocumentController::class, 'store'])->name('pacientes.documentos.store');
        Route::delete('pacientes/{paciente}/documentos/{documento}', [PatientDocumentController::class, 'destroy'])->name('pacientes.documentos.destroy');

        // Paciente — Anamneses
        Route::get('pacientes/{paciente}/anamneses/create', [AnamnesisController::class, 'create'])->name('pacientes.anamneses.create');
        Route::post('pacientes/{paciente}/anamneses/gerar-link', [AnamnesisController::class, 'generatePublicLink'])->name('pacientes.anamneses.gerar-link');
        Route::post('pacientes/{paciente}/anamneses', [AnamnesisController::class, 'store'])->name('pacientes.anamneses.store');
        Route::get('pacientes/{paciente}/anamneses/{anamnese}', [AnamnesisController::class, 'show'])->name('pacientes.anamneses.show');
        Route::delete('pacientes/{paciente}/anamneses/{anamnese}', [AnamnesisController::class, 'destroy'])->name('pacientes.anamneses.destroy');

        // Paciente — Prontuários
        Route::get('pacientes/{paciente}/prontuarios/create', [MedicalRecordController::class, 'create'])->name('pacientes.prontuarios.create');
        Route::post('pacientes/{paciente}/prontuarios', [MedicalRecordController::class, 'store'])->name('pacientes.prontuarios.store');
        Route::get('pacientes/{paciente}/prontuarios/{prontuario}', [MedicalRecordController::class, 'show'])->name('pacientes.prontuarios.show');
        Route::delete('pacientes/{paciente}/prontuarios/{prontuario}', [MedicalRecordController::class, 'destroy'])->name('pacientes.prontuarios.destroy');

        // Paciente — Fotos
        Route::post('pacientes/{paciente}/fotos', [PatientPhotoController::class, 'store'])->name('pacientes.fotos.store');
        Route::delete('pacientes/{paciente}/fotos/{foto}', [PatientPhotoController::class, 'destroy'])->name('pacientes.fotos.destroy');

        // Paciente — Contratos
        Route::post('pacientes/{paciente}/contratos', [PatientContractController::class, 'store'])->name('pacientes.contratos.store');
        Route::get('pacientes/{paciente}/contratos/{contrato}', [PatientContractController::class, 'show'])->name('pacientes.contratos.show');
        Route::delete('pacientes/{paciente}/contratos/{contrato}', [PatientContractController::class, 'destroy'])->name('pacientes.contratos.destroy');
    });

    // Comercial (Produtos + Estoque + Metas)
    Route::middleware('role:administrador,gestor,franqueado,colaborador')->prefix('comercial')->name('comercial.')->group(function () {
        Route::resource('produtos', ProductController::class);
        Route::get('estoque', [StockMovementController::class, 'index'])->name('estoque.index');
        Route::get('estoque/create', [StockMovementController::class, 'create'])->name('estoque.create');
        Route::post('estoque', [StockMovementController::class, 'store'])->name('estoque.store');
        // Metas de Venda
        Route::resource('metas', SaleGoalController::class);
        Route::post('metas/{meta}/registros', [SaleGoalController::class, 'storeEntry'])->name('metas.entries.store');
        Route::delete('metas/{meta}/registros/{registro}', [SaleGoalController::class, 'destroyEntry'])->name('metas.entries.destroy');
    });

    // CRM
    Route::middleware('role:administrador,gestor,franqueado,colaborador')->prefix('crm')->name('crm.')->group(function () {
        Route::get('/', [CrmController::class, 'index'])->name('index');
    });

    // Operacional
    Route::middleware('role:administrador,gestor,franqueado,colaborador')->prefix('operacional')->name('operacional.')->group(function () {
        Route::resource('agenda', AppointmentController::class)->parameters(['agenda' => 'agendamento']);
        Route::get('agenda-calendario', [AppointmentController::class, 'calendarData'])->name('agenda.calendar');
        Route::resource('avisos', AvisoController::class)->except(['edit', 'update']);
        Route::get('avisos-usuarios', [AvisoController::class, 'usersByClinic'])->name('avisos.users-by-clinic');

        // Treinamentos
        Route::get('treinamentos', [TreinamentoController::class, 'index'])->name('treinamentos.index');
        Route::get('treinamentos/pastas/create', [TreinamentoController::class, 'createFolder'])->name('treinamentos.pastas.create');
        Route::post('treinamentos/pastas', [TreinamentoController::class, 'storeFolder'])->name('treinamentos.pastas.store');
        Route::get('treinamentos/pastas/{pasta}', [TreinamentoController::class, 'showFolder'])->name('treinamentos.pasta.show');
        Route::delete('treinamentos/pastas/{pasta}', [TreinamentoController::class, 'destroyFolder'])->name('treinamentos.pasta.destroy');
        Route::get('treinamentos/pastas/{pasta}/create', [TreinamentoController::class, 'createFile'])->name('treinamentos.pasta.create-file');
        Route::post('treinamentos/pastas/{pasta}/arquivos', [TreinamentoController::class, 'storeFile'])->name('treinamentos.pasta.store-file');
        Route::get('treinamentos/{treinamento}', [TreinamentoController::class, 'show'])->name('treinamentos.show');
        Route::delete('treinamentos/{treinamento}', [TreinamentoController::class, 'destroy'])->name('treinamentos.destroy');

        // Banco de Imagens
        Route::get('banco-imagens', [BancoImagemController::class, 'index'])->name('banco-imagens.index');
        Route::get('banco-imagens/pastas/create', [BancoImagemController::class, 'createFolder'])->name('banco-imagens.pastas.create');
        Route::post('banco-imagens/pastas', [BancoImagemController::class, 'storeFolder'])->name('banco-imagens.pastas.store');
        Route::get('banco-imagens/pastas/{pasta}', [BancoImagemController::class, 'showFolder'])->name('banco-imagens.pasta.show');
        Route::delete('banco-imagens/pastas/{pasta}', [BancoImagemController::class, 'destroyFolder'])->name('banco-imagens.pasta.destroy');
        Route::get('banco-imagens/pastas/{pasta}/create', [BancoImagemController::class, 'createImage'])->name('banco-imagens.pasta.create-image');
        Route::post('banco-imagens/pastas/{pasta}/imagens', [BancoImagemController::class, 'storeImage'])->name('banco-imagens.pasta.store-image');
        Route::get('banco-imagens/{imagem}', [BancoImagemController::class, 'show'])->name('banco-imagens.show');
        Route::delete('banco-imagens/{imagem}', [BancoImagemController::class, 'destroy'])->name('banco-imagens.destroy');

        // Universidade Corporativa
        Route::get('universidade', [UniversidadeController::class, 'index'])->name('universidade.index');
        Route::get('universidade/create', [UniversidadeController::class, 'create'])->name('universidade.create');
        Route::post('universidade', [UniversidadeController::class, 'store'])->name('universidade.store');
        Route::get('universidade/{curso}', [UniversidadeController::class, 'show'])->name('universidade.show');
        Route::get('universidade/{curso}/edit', [UniversidadeController::class, 'edit'])->name('universidade.edit');
        Route::put('universidade/{curso}', [UniversidadeController::class, 'update'])->name('universidade.update');
        Route::delete('universidade/{curso}', [UniversidadeController::class, 'destroy'])->name('universidade.destroy');
        Route::get('universidade/{curso}/aulas/create', [UniversidadeController::class, 'createLesson'])->name('universidade.aulas.create');
        Route::post('universidade/{curso}/aulas', [UniversidadeController::class, 'storeLesson'])->name('universidade.aulas.store');
        Route::get('universidade/{curso}/aulas/{aula}', [UniversidadeController::class, 'showLesson'])->name('universidade.aulas.show');
        Route::get('universidade/{curso}/aulas/{aula}/edit', [UniversidadeController::class, 'editLesson'])->name('universidade.aulas.edit');
        Route::put('universidade/{curso}/aulas/{aula}', [UniversidadeController::class, 'updateLesson'])->name('universidade.aulas.update');
        Route::delete('universidade/{curso}/aulas/{aula}', [UniversidadeController::class, 'destroyLesson'])->name('universidade.aulas.destroy');
        Route::post('universidade/{curso}/aulas/reorder', [UniversidadeController::class, 'reorderLessons'])->name('universidade.aulas.reorder');
    });

    // CRM
    Route::middleware('role:administrador,gestor,franqueado,colaborador')->prefix('crm')->name('crm.')->group(function () {
        Route::resource('clientes', CrmClientController::class)->parameters(['clientes' => 'cliente']);
        Route::resource('leads', LeadController::class);
        Route::get('leads-kanban', [LeadController::class, 'kanban'])->name('leads.kanban');
        Route::get('leads-funil', [LeadController::class, 'funnel'])->name('leads.funnel');
        Route::post('leads/{lead}/converter', [LeadController::class, 'converter'])->name('leads.converter');
        Route::post('leads/{lead}/status', [LeadController::class, 'updateStatus'])->name('leads.update-status');
        Route::resource('oportunidades', OpportunityController::class)->parameters(['oportunidades' => 'oportunidade']);
        Route::get('oportunidades-kanban', [OpportunityController::class, 'kanban'])->name('oportunidades.kanban');
        Route::resource('tarefas', TaskController::class)->parameters(['tarefas' => 'tarefa']);
        Route::get('tarefas-kanban', [TaskController::class, 'kanban'])->name('tarefas.kanban');
        Route::post('tarefas/{tarefa}/concluir', [TaskController::class, 'concluir'])->name('tarefas.concluir');
        Route::post('tarefas/{tarefa}/status', [TaskController::class, 'updateStatus'])->name('tarefas.update-status');
    });

    // Mock (agenda only)
    Route::get('agenda', fn() => view('agenda.index'))->name('agenda.index');
});

// ─────────────────────────────────────────────────────────────────────────────
// Rotas públicas — Anamnese (paciente preenche sem login)
// ─────────────────────────────────────────────────────────────────────────────
Route::get('anamnese/{token}', [PublicAnamnesisController::class, 'fill'])->name('anamnese.public.fill');
Route::post('anamnese/{token}', [PublicAnamnesisController::class, 'submitFill'])->name('anamnese.public.submit');
Route::get('anamnese/{token}/obrigado', [PublicAnamnesisController::class, 'thanks'])->name('anamnese.public.obrigado');
Route::get('anamnese/assinatura/{token}', [PublicAnamnesisController::class, 'signature'])->name('anamnese.assinatura');
Route::post('anamnese/assinatura/{token}', [PublicAnamnesisController::class, 'submitSignature'])->name('anamnese.assinatura.submit');

require __DIR__.'/auth.php';
