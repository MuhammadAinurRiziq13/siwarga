<?php

use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = FakerFactory::create('id_ID'); // Create Indonesian Faker instance

        // Generate dummy keluarga data
        $keluargaData = [];
        for ($i = 0; $i < 50; $i++) {
            $keluargaData[] = [
                'noKK' => $faker->unique()->numerify('################'),
                'alamat' => $faker->address,
                'kecamatan' => $faker->citySuffix,
                'kabupaten_kota' => $faker->city,
                'provinsi' => $faker->state,
            ];
        }
        DB::table('keluarga')->insert($keluargaData);

        // Generate dummy warga data with references to keluarga
        $wargaData = [];
        foreach ($keluargaData as $keluarga) {
            for ($j = 0; $j < rand(2, 5); $j++) { // Generate 2-5 warga per keluarga
                $nama = $faker->name; // Generate full name using Faker

                // Truncate nama to 30 characters if it exceeds
                if (strlen($nama) > 30) {
                    $nama = substr($nama, 0, 30);
                }

                $wargaData[] = [
                    'NIK' => $faker->unique()->numerify('################'),
                    'noKK' => $keluarga['noKK'],
                    'nama' => $nama, // Use truncated nama
                    'tempat_lahir' => $faker->city,
                    'tanggal_lahir' => $faker->date('Y-m-d', '-18 years'),
                    'jenis_kelamin' => $faker->randomElement(['L', 'P']),
                    'agama' => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha']),
                    'status_pernikahan' => $faker->randomElement(['Belum Menikah', 'Menikah']),
                ];
            }
        }
        DB::table('warga')->insert($wargaData);

        // Generate dummy warga sementara data with references to warga
        $wargaSementaraData = [];
        foreach ($wargaData as $warga) {
            if (rand(0, 1)) { // 50% chance to generate warga sementara
                $wargaSementaraData[] = [
                    'NIK_warga_sementara' => $warga['NIK'],
                    'domisili_asal' => $faker->city
                ];
            }
        }
        DB::table('wargasementara')->insert($wargaSementaraData);
    }
}
