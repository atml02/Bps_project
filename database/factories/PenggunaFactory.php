<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pengguna>
 */
class PenggunaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $pendidikanOptions = ['<= SMA', 'DIPLOMA D1/D2/D3', 'S1', 'S2', 'S3'];
        $kelaminOptions = ['Laki-Laki', 'Perempuan'];
        $pekerjaanOptions = [
            'Guru', 'Dokter', 'Insinyur', 'Petani', 'Pengusaha', 
            'Programmer', 'Desainer', 'Pengacara', 'Aktor', 'Musisi'
        ];

        return [
            'nama_lengkap' => $this->faker->name(),
            'pend' => $this->faker->randomElement($pendidikanOptions),
            'kelamin' => $this->faker->randomElement($kelaminOptions),
            'pekerj' => $this->faker->randomElement($pekerjaanOptions),
        ];
    }
}
