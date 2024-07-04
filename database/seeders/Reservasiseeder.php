<?php

namespace Database\Seeders;

use App\Models\kegiatan;
use App\Models\reservasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Reservasiseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // note!!
        // user_id data tersedia pada seed 4, 5, dan 6
        // kegiatan_id 1 dan 2
        // riwayat id null
        // tgl_req tanggal hari dan kedepan
        // wkt_req enum(Sesi Pagi (08.00-12.00)', 'Sesi Siang (13.00-16.00)')'
        //temu_req berisi jika kegiatan_id bernilai 1 yang berisi nama yang ingin ditemui 'Kepala BPS Kabupaten Ogan Ilir (Ir. Suparindiyah)', 'Kepala Subbagian Umum (Ir. M. Honto Nazarudin)' dan nama random lainnya
        //temu_req berisi jika kegiatan_id bernilai 2 yang berisi enum('WhatsApp', 'Zoom Meeting', 'Google Meet')
        //keperluan berisi keperluan tamu tersebut untuk kegiatan kunjungan(1) atau Reservasi Data Online(2)
        //status enum('proses', 'disetujui', 'ditolak')
        $resData = [
            [
                'user_id' => '4',
                'kegiatan_id' => '1',
                'tgl_req' => '2024-06-29 08:51:58',
                'wkt_req' => 'Sesi Pagi (08.00-12.00)',
                'temu_req' => 'Kepala BPS Kabupaten Ogan Ilir (Ir. Suparindiyah)',
                'plat_req' => null,
                'Keperluan' => 'Konsultasi Data (Penelitian Akhir)',
                'status' => 'proses',
            ],
            [
                'user_id' => '5',
                'kegiatan_id' => '2',
                'tgl_req' => '2024-06-30 10:30:00',
                'wkt_req' => 'Sesi Siang (13.00-16.00)',
                'temu_req' => null,
                'plat_req' => 'Zoom Meeting',
                'Keperluan' => 'Reservasi Data Online untuk Analisis',
                'status' => 'disetujui',
            ],
            [
                'user_id' => '6',
                'kegiatan_id' => '1',
                'tgl_req' => '2024-07-01 09:00:00',
                'wkt_req' => 'Sesi Pagi (08.00-12.00)',
                'temu_req' => 'Kepala Subbagian Umum (Ir. M. Honto Nazarudin)',
                'plat_req' => null,
                'Keperluan' => 'Kunjungan untuk Diskusi Proyek',
                'status' => 'ditolak',
            ],
            [
                'user_id' => '4',
                'kegiatan_id' => '2',
                'tgl_req' => '2024-07-02 14:15:00',
                'wkt_req' => 'Sesi Siang (13.00-16.00)',
                'temu_req' => null,
                'plat_req' => 'Google Meet',
                'Keperluan' => 'Reservasi Data Online untuk Pengembangan Aplikasi',
                'status' => 'proses',
            ],
            [
                'user_id' => '5',
                'kegiatan_id' => '1',
                'tgl_req' => '2024-07-03 11:00:00',
                'wkt_req' => 'Sesi Pagi (08.00-12.00)',
                'temu_req' => 'Kepala BPS Kabupaten Ogan Ilir (Ir. Suparindiyah)',
                'plat_req' => null,
                'Keperluan' => 'Diskusi Kunjungan Lapangan',
                'status' => 'disetujui',
            ],
            [
                'user_id' => '6',
                'kegiatan_id' => '2',
                'tgl_req' => '2024-07-04 15:30:00',
                'wkt_req' => 'Sesi Siang (13.00-16.00)',
                'temu_req' => null,
                'plat_req' => 'WhatsApp',
                'Keperluan' => 'Reservasi Data Online untuk Studi Kasus',
                'status' => 'ditolak',
            ],
            [
                'user_id' => '4',
                'kegiatan_id' => '1',
                'tgl_req' => '2024-07-05 09:45:00',
                'wkt_req' => 'Sesi Pagi (08.00-12.00)',
                'temu_req' => 'Kepala Subbagian Umum (Ir. M. Honto Nazarudin)',
                'plat_req' => null,
                'Keperluan' => 'Kunjungan untuk Evaluasi Program',
                'status' => 'proses',
            ],
            [
                'user_id' => '5',
                'kegiatan_id' => '2',
                'tgl_req' => '2024-07-06 13:00:00',
                'wkt_req' => 'Sesi Siang (13.00-16.00)',
                'temu_req' => null,
                'plat_req' => 'Zoom Meeting',
                'Keperluan' => 'Reservasi Data Online untuk Penelitian',
                'status' => 'disetujui',
            ],
            [
                'user_id' => '6',
                'kegiatan_id' => '1',
                'tgl_req' => '2024-07-07 10:30:00',
                'wkt_req' => 'Sesi Pagi (08.00-12.00)',
                'temu_req' => 'Kepala BPS Kabupaten Ogan Ilir (Ir. Suparindiyah)',
                'plat_req' => null,
                'Keperluan' => 'Kunjungan untuk Pengumpulan Data',
                'status' => 'ditolak',
            ],
            [
                'user_id' => '4',
                'kegiatan_id' => '2',
                'tgl_req' => '2024-07-08 14:00:00',
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
