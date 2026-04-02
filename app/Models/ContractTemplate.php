<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractTemplate extends Model
{
    protected $fillable = [
        'title',
        'type',
        'content',
    ];

    public static array $types = [
        'Consentimento',
        'Prestação de Serviços',
        'Plano de Tratamento',
        'Termo de Autorização',
        'Termo de Quitação',
        'Outro',
    ];

    /**
     * Replace template variables with patient and clinic data.
     */
    public function render(Patient $patient, Clinic $clinic): string
    {
        $enderecoCompleto = collect([
            $patient->street,
            $patient->number ? 'nº ' . $patient->number : null,
            $patient->complement,
            $patient->neighborhood,
            $patient->city,
            $patient->state,
            $patient->cep,
        ])->filter()->implode(', ');

        $empresaEnderecoCompleto = collect([
            $clinic->street,
            $clinic->number ? 'nº ' . $clinic->number : null,
            $clinic->complement,
            $clinic->neighborhood,
            $clinic->city,
            $clinic->state,
            $clinic->cep,
        ])->filter()->implode(', ');

        $vars = [
            '{nome_completo}'             => $patient->name ?? '',
            '{email}'                     => $patient->email ?? '',
            '{telefone}'                  => $patient->phone ?? '',
            '{data_nascimento}'           => $patient->birth_date?->format('d/m/Y') ?? '',
            '{cpf}'                       => $patient->cpf ?? '',
            '{rg}'                        => $patient->rg ?? '',
            '{cep}'                       => $patient->cep ?? '',
            '{logradouro}'                => $patient->street ?? '',
            '{numero}'                    => $patient->number ?? '',
            '{complemento}'               => $patient->complement ?? '',
            '{bairro}'                    => $patient->neighborhood ?? '',
            '{cidade}'                    => $patient->city ?? '',
            '{estado}'                    => $patient->state ?? '',
            '{endereco_completo}'         => $enderecoCompleto,
            '{data_hoje}'                 => now()->format('d/m/Y'),
            '{unidade}'                   => $clinic->name ?? '',
            '{empresa_razao_social}'      => $clinic->razao_social ?? $clinic->name ?? '',
            '{empresa_cnpj}'              => $clinic->cnpj ?? '',
            '{empresa_telefone}'          => $clinic->phone ?? '',
            '{empresa_email}'             => $clinic->email ?? '',
            '{empresa_logradouro}'        => $clinic->street ?? '',
            '{empresa_numero}'            => $clinic->number ?? '',
            '{empresa_complemento}'       => $clinic->complement ?? '',
            '{empresa_bairro}'            => $clinic->neighborhood ?? '',
            '{empresa_cidade}'            => $clinic->city ?? '',
            '{empresa_estado}'            => $clinic->state ?? '',
            '{empresa_cep}'               => $clinic->cep ?? '',
            '{empresa_endereco_completo}' => $empresaEnderecoCompleto,
            '{empresa_responsavel}'       => $clinic->rep_name ?? '',
            '{empresa_responsavel_cpf}'   => $clinic->rep_cpf ?? '',
        ];

        return str_replace(array_keys($vars), array_values($vars), $this->content);
    }
}
