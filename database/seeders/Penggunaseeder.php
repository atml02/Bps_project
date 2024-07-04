<?php

namespace Database\Seeders;

use App\Models\pengguna;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Penggunaseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'nama_lengkap'=>'Deva Admin',
                'pend'=>'S3',
                'kelamin'=>'Laki-Laki',
                'pekerj'=>'Kepala BPS Kabupaten Ogan Ilir'
            ],
            [
                'nama_lengkap'=>'Tian Pegawai',
                'pend'=>'S1',
                'kelamin'=>'Laki-Laki',
                'pekerj'=>'Kepala Subbagian Umum'
            ],
            [
                'nama_lengkap'=>'Agus Pegawai',
                'pend'=>'S1',
                'kelamin'=>'Laki-Laki',
                'pekerj'=>'Tim Fungsional'
            ],
            [
                'nama_lengkap'=>'Robby Tamu',
                'pend'=>'S2',
                'kelamin'=>'Laki-Laki',
                'pekerj'=>'PNS'
            ],
            [
                'nama_lengkap'=>'Sumi Tamu',
                'pend'=>'<= SMA',
                'kelamin'=>'Perempuan',
                'pekerj'=>'Wira Swasta'
            ],
            [
                'nama_lengkap'=>'Yogta Tamu',
                'pend'=>'S1',
                'kelamin'=>'Laki-Laki',
                'pekerj'=>'Petani'
            ]
            
        ];
        foreach ($userData as $key => $val) {
            pengguna::create($val);
        }
    }
}
