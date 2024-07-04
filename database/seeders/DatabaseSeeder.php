<?php

namespace Database\Seeders;

use App\Models\kegiatan;
use App\Models\pengguna;
use App\Models\reservasi;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        
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

        $userData = [
            [
                'nama_lengkap'=>'Ini nama Admin',
                'pend'=>'S3',
                'kelamin'=>'Laki-Laki',
                'pekerj'=>'Kepala BPS Kabupaten Ogan Ilir'
            ],
            [
                'nama_lengkap'=>'Ini Nama Pegawai',
                'pend'=>'S1',
                'kelamin'=>'Laki-Laki',
                'pekerj'=>'Kepala Subbagian Umum'
            ],
            [
                'nama_lengkap'=>'ini Tim Fungsi Pegawai',
                'pend'=>'S1',
                'kelamin'=>'Laki-Laki',
                'pekerj'=>'Tim Fungsional'
            ],
            [
                'nama_lengkap'=>'nama Tamu kosong',
                'pend'=>'S2',
                'kelamin'=>'Laki-Laki',
                'pekerj'=>'PNS'
            ],
            [
                'nama_lengkap'=>'nama Tamu kesatu',
                'pend'=>'<= SMA',
                'kelamin'=>'Perempuan',
                'pekerj'=>'Wira Swasta'
            ],
            [
                'nama_lengkap'=>'nama Tamu kedua',
                'pend'=>'S1',
                'kelamin'=>'Laki-Laki',
                'pekerj'=>'Petani'
            ]
            
        ];
        foreach ($userData as $key => $val) {
            pengguna::create($val);
        }

        $user1Data = [
            [
                'email'=>'admin@gmail.com',
                'no_tlp'=>'085676423486',
                'password'=>bcrypt('123456'),
                'pengguna_id'=>'1',
                'role'=>'admin'
            ],
            [
                'email'=>'pegawai@gmail.com',
                'no_tlp'=>'085676420945',
                'password'=>bcrypt('123456'),
                'pengguna_id'=>'2',
                'role'=>'pegawai'
            ],
            [
                'email'=>'pegawai2@gmail.com',
                'no_tlp'=>'085576421234',
                'password'=>bcrypt('123456'),
                'pengguna_id'=>'3',
                'role'=>'pegawai'
            ],
            [
                'email'=>'tamu0@gmail.com',
                'no_tlp'=>'081276422566',
                'password'=>bcrypt('123456'),
                'pengguna_id'=>'4',
                'role'=>'tamu'
            ],
            [
                'email'=>'tamu1@gmail.com',
                'no_tlp'=>'085676424231',
                'password'=>bcrypt('123456'),
                'pengguna_id'=>'5',
                'role'=>'tamu'
            ],
            [
                'email'=>'tamu2@gmail.com',
                'no_tlp'=>'081287568787',
                'password'=>bcrypt('123456'),
                'pengguna_id'=>'6',
                'role'=>'tamu'
            ]
        ];
        foreach ($user1Data as $key => $val) {
            User::create($val);
        }

        $resData = [
            [
                'user_id' => '4',
                'kegiatan_id' => '1',
                'riwayat_id' => null,
                'tgl_req' => '2024-07-09 08:51:58',
                'wkt_req' => 'Sesi Pagi (08.00-12.00)',
                'temu_req' => 'Kepala BPS Kabupaten Ogan Ilir (Ir. Suparindiyah)',
                'plat_req' => null,
                'Keperluan' => 'Konsultasi Data (Penelitian Akhir)',
                'status' => 'proses',
            ],
            [
                'user_id' => '5',
                'kegiatan_id' => '2',
                'riwayat_id' => null,
                'tgl_req' => '2024-07-08 10:30:00',
                'wkt_req' => 'Sesi Siang (13.00-16.00)',
                'temu_req' => null,
                'plat_req' => 'Zoom Meeting',
                'Keperluan' => 'Reservasi Data Online untuk Analisis',
                'status' => 'proses',
            ],
            [
                'user_id' => '6',
                'kegiatan_id' => '1',
                'riwayat_id' => null,
                'tgl_req' => '2024-07-07 09:00:00',
                'wkt_req' => 'Sesi Pagi (08.00-12.00)',
                'temu_req' => 'Kepala Subbagian Umum (Ir. M. Honto Nazarudin)',
                'plat_req' => null,
                'Keperluan' => 'Kunjungan untuk Diskusi Proyek',
                'status' => 'proses',
            ],
            [
                'user_id' => '4',
                'kegiatan_id' => '2',
                'riwayat_id' => null,
                'tgl_req' => '2024-07-07 14:15:00',
                'wkt_req' => 'Sesi Siang (13.00-16.00)',
                'temu_req' => null,
                'plat_req' => 'Google Meet',
                'Keperluan' => 'Reservasi Data Online untuk Pengembangan Aplikasi',
                'status' => 'proses',
            ],
            [
                'user_id' => '5',
                'kegiatan_id' => '1',
                'riwayat_id' => null,
                'tgl_req' => '2024-07-06 11:00:00',
                'wkt_req' => 'Sesi Pagi (08.00-12.00)',
                'temu_req' => 'Kepala BPS Kabupaten Ogan Ilir (Ir. Suparindiyah)',
                'plat_req' => null,
                'Keperluan' => 'Diskusi Kunjungan Lapangan',
                'status' => 'proses',
            ],
            [
                'user_id' => '6',
                'kegiatan_id' => '2',
                'riwayat_id' => null,
                'tgl_req' => '2024-07-06 15:30:00',
                'wkt_req' => 'Sesi Siang (13.00-16.00)',
                'temu_req' => null,
                'plat_req' => 'WhatsApp',
                'Keperluan' => 'Reservasi Data Online untuk Studi Kasus',
                'status' => 'proses',
            ],
            [
                'user_id' => '4',
                'kegiatan_id' => '1',
                'riwayat_id' => null,
                'tgl_req' => '2024-07-06 09:45:00',
                'wkt_req' => 'Sesi Pagi (08.00-12.00)',
                'temu_req' => 'Kepala Subbagian Umum (Ir. M. Honto Nazarudin)',
                'plat_req' => null,
                'Keperluan' => 'Kunjungan untuk Evaluasi Program',
                'status' => 'proses',
            ],
            [
                'user_id' => '5',
                'kegiatan_id' => '2',
                'riwayat_id' => null,
                'tgl_req' => '2024-07-05 13:00:00',
                'wkt_req' => 'Sesi Siang (13.00-16.00)',
                'temu_req' => null,
                'plat_req' => 'Zoom Meeting',
                'Keperluan' => 'Reservasi Data Online untuk Penelitian',
                'status' => 'proses',
            ],
            [
                'user_id' => '6',
                'kegiatan_id' => '1',
                'riwayat_id' => null,
                'tgl_req' => '2024-07-04 10:30:00',
                'wkt_req' => 'Sesi Pagi (08.00-12.00)',
                'temu_req' => 'Kepala BPS Kabupaten Ogan Ilir (Ir. Suparindiyah)',
                'plat_req' => null,
                'Keperluan' => 'Kunjungan untuk Pengumpulan Data',
                'status' => 'proses',
            ],
            [
                'user_id' => '4',
                'kegiatan_id' => '2',
                'riwayat_id' => null,
                'tgl_req' => '2024-07-04 14:00:00',
                'wkt_req' => 'Sesi Siang (13.00-16.00)',
                'temu_req' => null,
                'plat_req' => 'Google Meet',
                'Keperluan' => 'Reservasi Data Online untuk Workshop',
                'status' => 'proses',
            ],
        ];
        foreach ($resData as $key => $val) {
            reservasi::create($val);
        }
    }
}
