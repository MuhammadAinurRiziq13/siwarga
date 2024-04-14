<?php

namespace Database\Factories;

use Faker\Generator as Faker;
use App\Models\FamilyModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class FamilyModelFactory extends Factory
{
    protected $model = FamilyModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');

        return [
            'noKK' => $faker->unique()->numerify('##############'), // Nomor Kartu Keluarga dengan 12 digit acak
            'alamat' => $faker->address,
            'kecamatan' => $faker->citySuffix,
            'kabupaten_kota' => $faker->city,
            'provinsi' => $faker->state,
        ];
    }
}
