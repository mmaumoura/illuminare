<?php

namespace App\Enums;

enum RoleEnum: string
{
    case Administrador = 'administrador';
    case Gestor        = 'gestor';
    case Colaborador   = 'colaborador';
    case Franqueado    = 'franqueado';

    public function label(): string
    {
        return match($this) {
            self::Administrador => 'Administrador',
            self::Gestor        => 'Gestor',
            self::Colaborador   => 'Colaborador',
            self::Franqueado    => 'Franqueado',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::Administrador => 'Acesso total ao sistema, gerencia usuários e configurações globais.',
            self::Gestor        => 'Gerencia equipes, relatórios e operações da sua unidade.',
            self::Colaborador   => 'Acesso às funcionalidades operacionais do dia a dia.',
            self::Franqueado    => 'Acesso restrito às informações da sua franquia.',
        };
    }
}
