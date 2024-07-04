<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Guesser\Name;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Userseed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1Data = [
            [
                'email'=>'devaadmin@gmail.com',
                'no_tlp'=>'085676423486',
                'password'=>bcrypt('123456'),
                'pengguna_id'=>'1',
                'role'=>'admin'
            ],
            [
                'email'=>'tianpegawai@gmail.com',
                'no_tlp'=>'085676420945',
                'password'=>bcrypt('123456'),
                'pengguna_id'=>'2',
                'role'=>'pegawai'
            ],
            [
                'email'=>'agustamu@gmail.com',
                'no_tlp'=>'085576421234',
                'password'=>bcrypt('123456'),
                'pengguna_id'=>'3',
                'role'=>'pegawai'
            ],
            [
                'email'=>'robbytamu@gmail.com',
                'no_tlp'=>'081276422566',
                'password'=>bcrypt('123456'),
                'pengguna_id'=>'4',
                'role'=>'tamu'
            ],
            [
                'email'=>'sumitamu@gmail.com',
                'no_tlp'=>'085676424231',
                'password'=>bcrypt('123456'),
                'pengguna_id'=>'5',
                'role'=>'tamu'
            ],
            [
                'email'=>'yogtatamu@gmail.com',
                'no_tlp'=>'081287568787',
                'password'=>bcrypt('123456'),
                'pengguna_id'=>'6',
                'role'=>'tamu'
            ]
        ];
        foreach ($user1Data as $key => $val) {
            User::create($val);
        }
    }
}
