<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\reservasi>
 */
class reservasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        $temuOptions = [
            'Kepala BPS Kabupaten Ogan Ilir (Ir. Suparindiyah)',
            'Kepala Subbagian Umum (Ir. M. Honto Nazarudin)'
        ];

        $kegiatanId = $this->faker->randomElement([1, 2]);

        return [
            // 'user_id' => User::factory(),
            // 'user_id' => $this->faker->randomElement(['1','2','3','4','5','6']),
            'user_id' => $this->faker->randomElement(range(67, 141)),
            'kegiatan_id' => $kegiatanId,
            'tgl_req' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'wkt_req' => $this->faker->randomElement(['Pagi', 'Siang']),
            'temu_req' => $kegiatanId == 1 ? $this->faker->randomElement($temuOptions) : null,
            'plat_req' => $kegiatanId == 2 ? $this->faker->randomElement(['WhatsApp', 'Zoom Meeting', 'Google Meet']) : null,
            'Keperluan' => $this->faker->text(),
            'status' => $this->faker->randomElement(['proses', 'disetujui', 'ditolak']),
        ];
    
    }
}
