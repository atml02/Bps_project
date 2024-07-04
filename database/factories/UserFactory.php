<?php

namespace Database\Factories;

use App\Models\pengguna;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'no_tlp' => $this->faker->phoneNumber(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('123456'),
            'pengguna_id' => pengguna::factory(),
            'remember_token' => Str::random(4),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
    public function admin_log(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }
    public function pegawai_log(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'pegawai',
        ]);
    }
}
