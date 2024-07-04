<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class riwayat extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $riwData = [
            [
                'nama'=>'Kunjungan'
            ],
            [
                'nama'=>'Konsultasi Data Online'
            ]
            
        ];
        foreach ($riwData as $key => $val) {
            riwayat::create($val);
        }
    }
}
