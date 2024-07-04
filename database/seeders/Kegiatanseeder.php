<?php

namespace Database\Seeders;

use App\Models\kegiatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Kegiatanseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kegData = [
            [
                'nama'=>'Kunjungan'
            ],
            [
                'nama'=>'Konsultasi Data Online'
            ]
            
        ];
        foreach ($kegData as $key => $val) {
            kegiatan::create($val);
        }
    }
}
