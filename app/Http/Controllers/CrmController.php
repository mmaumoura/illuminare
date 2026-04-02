<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class CrmController extends Controller
{
    public function index(): View
    {
        $clientes = [
            ['id' => 1, 'nome' => 'Maria Silva', 'email' => 'maria@email.com', 'telefone' => '(11) 98765-4321', 'status' => 'Ativo', 'ultima_compra' => '15/02/2026'],
            ['id' => 2, 'nome' => 'João Santos', 'email' => 'joao@email.com', 'telefone' => '(11) 91234-5678', 'status' => 'Ativo', 'ultima_compra' => '10/02/2026'],
            ['id' => 3, 'nome' => 'Ana Costa', 'email' => 'ana@email.com', 'telefone' => '(11) 99876-5432', 'status' => 'Inativo', 'ultima_compra' => '05/01/2026'],
        ];

        $leads = [
            ['id' => 1, 'nome' => 'Carlos Souza', 'origem' => 'Site', 'status' => 'Novo', 'temperatura' => 'Quente', 'data' => '08/03/2026'],
            ['id' => 2, 'nome' => 'Beatriz Lima', 'origem' => 'Instagram', 'status' => 'Contato', 'temperatura' => 'Morno', 'data' => '07/03/2026'],
            ['id' => 3, 'nome' => 'Pedro Alves', 'origem' => 'Indicação', 'status' => 'Negociação', 'temperatura' => 'Quente', 'data' => '06/03/2026'],
        ];

        return view('crm.index', compact('clientes', 'leads'));
    }
}
