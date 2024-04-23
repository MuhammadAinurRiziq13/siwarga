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
            'NIK' => $faker->unique()->numerify('################'), // Nomor Induk Kependudukan dengan 16 digit acak
            'noKK' => function () {
                return FamilyModel::inRandomOrder()->first()->noKK; // Mengambil nomor KK dari factory Keluarga
            },
            'nama' => $faker->name,
            'tempat_lahir' => $faker->city,
            'tanggal_lahir' => $faker->date,
            'jenis_kelamin' => $faker->randomElement(['L', 'P']), // L untuk Laki-laki, P untuk Perempuan
            'agama' => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
            'status_pernikahan' => $faker->randomElement(['Belum Menikah', 'Menikah']),
        ];
    }
}