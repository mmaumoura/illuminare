<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Mapa de permissões por grupo com quais roles as recebem.
     *
     * Roles que não constam na lista NÃO recebem a permissão.
     */
    private array $permissions = [
        // ──────────────────────────────────────────────────────
        // Usuários
        // ──────────────────────────────────────────────────────
        ['slug' => 'usuarios.visualizar',  'name' => 'Visualizar Usuários',  'group' => 'Usuários',  'roles' => ['administrador', 'gestor']],
        ['slug' => 'usuarios.criar',       'name' => 'Criar Usuários',       'group' => 'Usuários',  'roles' => ['administrador']],
        ['slug' => 'usuarios.editar',      'name' => 'Editar Usuários',      'group' => 'Usuários',  'roles' => ['administrador']],
        ['slug' => 'usuarios.excluir',     'name' => 'Excluir Usuários',     'group' => 'Usuários',  'roles' => ['administrador']],

        // ──────────────────────────────────────────────────────
        // Roles / Permissões
        // ──────────────────────────────────────────────────────
        ['slug' => 'roles.visualizar',     'name' => 'Visualizar Roles',     'group' => 'Roles',     'roles' => ['administrador']],
        ['slug' => 'roles.gerenciar',      'name' => 'Gerenciar Roles',      'group' => 'Roles',     'roles' => ['administrador']],

        // ──────────────────────────────────────────────────────
        // Relatórios
        // ──────────────────────────────────────────────────────
        ['slug' => 'relatorios.visualizar','name' => 'Visualizar Relatórios','group' => 'Relatórios','roles' => ['administrador', 'gestor', 'franqueado']],
        ['slug' => 'relatorios.exportar',  'name' => 'Exportar Relatórios',  'group' => 'Relatórios','roles' => ['administrador', 'gestor']],

        // ──────────────────────────────────────────────────────
        // Dashboard
        // ──────────────────────────────────────────────────────
        ['slug' => 'dashboard.visualizar', 'name' => 'Visualizar Dashboard', 'group' => 'Dashboard', 'roles' => ['administrador', 'gestor', 'colaborador', 'franqueado']],

        // ──────────────────────────────────────────────────────
        // Franquias
        // ──────────────────────────────────────────────────────
        ['slug' => 'franquias.visualizar', 'name' => 'Visualizar Franquias', 'group' => 'Franquias', 'roles' => ['administrador', 'gestor', 'franqueado']],
        ['slug' => 'franquias.criar',      'name' => 'Criar Franquias',      'group' => 'Franquias', 'roles' => ['administrador']],
        ['slug' => 'franquias.editar',     'name' => 'Editar Franquias',     'group' => 'Franquias', 'roles' => ['administrador', 'gestor']],
        ['slug' => 'franquias.excluir',    'name' => 'Excluir Franquias',    'group' => 'Franquias', 'roles' => ['administrador']],

        // ──────────────────────────────────────────────────────
        // Operacional (colaborador + gestor)
        // ──────────────────────────────────────────────────────
        ['slug' => 'operacional.visualizar','name' => 'Visualizar Operacional','group' => 'Operacional','roles' => ['administrador', 'gestor', 'colaborador']],
        ['slug' => 'operacional.executar', 'name' => 'Executar Operacional', 'group' => 'Operacional','roles' => ['administrador', 'gestor', 'colaborador']],
    ];

    public function run(): void
    {
        foreach ($this->permissions as $data) {
            $roles = $data['roles'];

            $permission = Permission::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'name'        => $data['name'],
                    'group'       => $data['group'],
                    'description' => $data['name'],
                ]
            );

            $roleIds = Role::whereIn('slug', $roles)->pluck('id');
            $permission->roles()->syncWithoutDetaching($roleIds);
        }
    }
}
