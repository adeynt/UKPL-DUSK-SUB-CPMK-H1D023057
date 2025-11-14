<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AlatLabFactory extends Factory
{
    public function definition(): array
    {
        return [
            'kode_alat' => 'ALAT-' . $this->faker->unique()->numerify('###'),
            'nama_alat' => 'Alat ' . $this->faker->word(),
            'lokasi'    => 'Ruang ' . $this->faker->randomElement(['A1','B2','C3']),
            'jumlah'    => $this->faker->numberBetween(1, 10),
            'kondisi'   => $this->faker->randomElement(['Baik', 'Rusak Ringan', 'Rusak Berat']),
        ];
    }
}
