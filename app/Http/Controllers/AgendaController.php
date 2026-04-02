<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class AgendaController extends Controller
{
    public function index(): View
    {
        $eventos = [
            ['id' => 1, 'titulo' => 'Consulta - Maria Silva', 'data' => '2026-03-10', 'hora' => '10:00', 'paciente' => 'Maria Silva', 'procedimento' => 'Harmonização Facial', 'status' => 'Confirmado', 'unidade' => 'Unidade Centro'],
            ['id' => 2, 'titulo' => 'Procedimento - João Santos', 'data' => '2026-03-10', 'hora' => '14:30', 'paciente' => 'João Santos', 'procedimento' => 'Bioestimulador', 'status' => 'Pendente', 'unidade' => 'Unidade Plaza'],
            ['id' => 3, 'titulo' => 'Retorno - Ana Costa', 'data' => '2026-03-11', 'hora' => '09:00', 'paciente' => 'Ana Costa', 'procedimento' => 'Preenchimento Labial', 'status' => 'Confirmado', 'unidade' => 'Unidade Centro'],
            ['id' => 4, 'titulo' => 'Avaliação - Carlos Souza', 'data' => '2026-03-11', 'hora' => '16:00', 'paciente' => 'Carlos Souza', 'procedimento' => 'Avaliação', 'status' => 'Aguardando', 'unidade' => 'Unidade Plaza'],
        ];

        return view('agenda.index', compact('eventos'));
    }
}
