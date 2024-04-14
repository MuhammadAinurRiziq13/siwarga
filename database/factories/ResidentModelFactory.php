<?php

namespace Database\Factories;

use Faker\Generator as Faker;

use App\Models\FamilyModel;
use App\Models\ResidentModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResidentModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ResidentModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = \Faker\Factory::create('id_ID');
        return [
            'NIK' => $this->faker->unique()->numerify('################'), // Nomor Induk Kependudukan dengan 16 digit acak
            'noKK' => function () {
                return FamilyModel::inRandomOrder()->first()->noKK; // Mengambil nomor KK dari factory Keluarga
            },
            'nama' => $this->faker->name,
            'tempat_lahir' => $this->faker->city,
            'tanggal_lahir' => $this->faker->date,
            'jenis_kelamin' => $this->faker->randomElement(['L', 'P']), // L untuk Laki-laki, P untuk Perempuan
            'agama' => $this->faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
            'status_pernikahan' => $this->faker->randomElement(['Belum Menikah', 'Menikah']),
        ];
    }
}
