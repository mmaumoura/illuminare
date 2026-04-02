<?php

namespace Database\Seeders;

use App\Models\Clinic;
use Illuminate\Database\Seeder;

class ClinicSeeder extends Seeder
{
    public function run(): void
    {
        // Remove registros antigos com nome Bellife se existirem
        Clinic::whereIn('name', ['Bellife PNZ', 'Bellife REC', 'Bellife FOR'])->forceDelete();

        $clinics = [
            [
                'name'         => 'Illuminare PNZ',
                'phone'        => '(87) 99999-0001',
                'email'        => 'pnz@illuminare.com.br',
                'cep'          => '56300-000',
                'street'       => 'Rua das Flores',
                'number'       => '100',
                'neighborhood' => 'Centro',
                'city'         => 'Petrolina',
                'state'        => 'PE',
                'active'       => true,
            ],
            [
                'name'         => 'Illuminare REC',
                'phone'        => '(81) 99999-0002',
                'email'        => 'rec@illuminare.com.br',
                'cep'          => '50050-000',
                'street'       => 'Av. Boa Viagem',
                'number'       => '500',
                'neighborhood' => 'Boa Viagem',
                'city'         => 'Recife',
                'state'        => 'PE',
                'active'       => true,
            ],
            [
                'name'         => 'Illuminare FOR',
                'phone'        => '(85) 99999-0003',
                'email'        => 'for@illuminare.com.br',
                'cep'          => '60060-000',
                'street'       => 'Av. Beira Mar',
                'number'       => '200',
                'neighborhood' => 'Meireles',
                'city'         => 'Fortaleza',
                'state'        => 'CE',
                'active'       => true,
            ],
        ];

        foreach ($clinics as $data) {
            Clinic::updateOrCreate(['name' => $data['name']], $data);
        }
    }
}
