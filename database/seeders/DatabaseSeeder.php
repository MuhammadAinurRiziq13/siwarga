<?php

use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        $keluargaKurangMampuData = [];
        $keluargaPraSejahteraData = [];
        for ($i = 0; $i < 50; $i++) {
            $noKK = rand(1, 9) . $faker->unique()->numerify('################');
            $keluargaData[] = [
                'noKK' => $noKK,
                'alamat' => $faker->address,
                'kelurahan_desa' => $faker->unique()->city,
                'kecamatan' => $faker->citySuffix,
                'kabupaten_kota' => $faker->city,
                'provinsi' => $faker->state,
            ];

            // Insert keluarga kurang mampu
            if (rand(0, 8) === 0) {
                $keluargaKurangMampuData[] = [
                    'noKK' => $noKK,
                    'c1' => $faker->numberBetween(1, 5),
                    'c2' => $faker->randomFloat(2, 10000, 20000),
                    'c3' => $faker->randomFloat(2, 10000, 20000),
                    'c4' => $faker->numberBetween(100, 500),
                    'c5' => $faker->numberBetween(1, 5),
                ];
            }

            // if (rand(0, 8) === 0) {
            //     $keluargaPraSejahteraData[] = [
            //         'noKK' => $noKK,
            //         'c1' => $faker->numberBetween(1, 5),
            //         'c2' => $faker->randomFloat(2, 10000, 20000),
            //         'c3' => $faker->randomFloat(2, 10000, 20000),
            //         'c4' => $faker->numberBetween(100, 500),
            //         'c5' => $faker->numberBetween(1, 5),
            //         // Add more columns as needed
            //     ];
            // }
        }
        DB::table('keluarga')->insert($keluargaData);
        // DB::table('keluargaprasejahtera')->insert($keluargaPraSejahteraData);
        DB::table('keluargakurangmampu')->insert($keluargaKurangMampuData);


        // Generate dummy warga data with references to keluarga
        $wargaData = [];
        foreach ($keluargaData as $keluarga) {
            $jumlahWarga = rand(2, 7); // Generate 2-5 warga per keluarga
            $kepalaKelurahanAdded = false; // Flag untuk menandai apakah kepala keluarga sudah ditambahkan

            for ($j = 0; $j < $jumlahWarga; $j++) {
                $nama = $faker->name; // Generate full name using Faker

                // Truncate nama to 30 characters if it exceeds
                if (strlen($nama) > 30) {
                    $nama = substr($nama, 0, 30);
                }

                $startDate = '-80 years'; // Rentang umur mulai dari 0 sampai 80 tahun yang lalu
                $endDate = '-0 years'; // Rentang umur mulai dari 80 tahun yang lalu hingga sekarang

                $warga = [
                    'NIK' => rand(1, 9) . $faker->unique()->numerify('################'),
                    'noKK' => $keluarga['noKK'],
                    'nama' => $nama, // Use truncated nama
                    'tempat_lahir' => $faker->city,
                    'tanggal_lahir' => $faker->dateTimeBetween($startDate, $endDate)->format('Y-m-d'),
                    'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                    'agama' => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha']),
                    'status_pernikahan' => $faker->randomElement(['Belum Menikah', 'Menikah']),
                    'status_keluarga' => $faker->randomElement(['istri', 'anak']),
                    'status_kerja' => $faker->randomElement(['Kerja', 'Tidak Kerja']),
                    // 'kepala_keluarga' => false, // Setiap warga tidak menjadi kepala keluarga secara default
                ];

                // Jika kepala keluarga belum ditambahkan dan ini adalah warga pertama dalam keluarga, tandai sebagai kepala keluarga
                if (!$kepalaKelurahanAdded && $j === 0) {
                    $warga['status_keluarga'] = 'kepala keluarga';
                    $warga['status_kerja'] = 'Kerja';
                    $kepalaKelurahanAdded = true;
                }

                $wargaData[] = $warga;
            }
        }

        DB::table('warga')->insert($wargaData);

        // Generate dummy warga sementara data with references to warga
        $wargaSementaraData = [];
        foreach ($wargaData as $warga) {
            if (rand(0, 4) === 0) { // 20% chance to generate warga sementara
                $wargaSementaraData[] = [
                    'NIK_warga_sementara' => $warga['NIK'],
                    'alamat_asal' => $faker->city
                ];
            }
        }
        DB::table('wargasementara')->insert($wargaSementaraData);

        // Generate dummy pengajuaneditdatawarga data with references to warga
        $pengajuanEditDataWargaData = [];
        foreach ($wargaData as $warga) {
            $keterangan = $faker->sentence; // Generate full sentence for keterangan

            // Truncate keterangan to 50 characters if it exceeds
            if (strlen($keterangan) > 20) {
                $keterangan = substr($keterangan, 0, 20);
            }

            // Generate pengajuaneditdatawarga with 10% chance
            if (rand(0, 9) === 0) { // 10% chance to generate pengajuaneditdatawarga
                $pengajuanEditDataWargaData[] = [
                    'NIK' => $warga['NIK'],
                    'nama' => $warga['nama'], // Generate different name for pengajuan
                    'tempat_lahir' => $warga['tempat_lahir'],
                    'tanggal_lahir' => $warga['tanggal_lahir'],
                    'jenis_kelamin' => $warga['jenis_kelamin'],
                    'agama' => $warga['agama'],
                    'status_pernikahan' => $warga['status_pernikahan'],
                    'status_kerja' => $warga['status_kerja'],
                    'keterangan' => $keterangan, // Use truncated keterangan
                    'status' => $faker->randomElement(['selesai', 'proses', 'ditolak']),
                    'no_hp' => $faker->phoneNumber,
                ];
            }
        }
        DB::table('pengajuaneditdatawarga')->insert($pengajuanEditDataWargaData);

        // $buktiPengajuanEditDataWargaData = [];
        // foreach ($pengajuanEditDataWargaData as $pengajuan) {
        //     $nama_bukti = $faker->sentence;

        //     if (strlen($nama_bukti) > 20) {
        //         $nama_bukti = substr($nama_bukti, 0, 20);
        //     }

        //     $buktiPengajuanEditDataWargaData[] = [
        //         'NIK' => $pengajuan['NIK'],
        //         'nama_bukti' => $nama_bukti
        //     ];
        // }
        // DB::table('bukti_pengajuan_edit_data_warga')->insert($buktiPengajuanEditDataWargaData);

        $pengajuanSuratPengantar = [];
        foreach ($wargaData as $warga) {
            $keperluan = $faker->sentence; // Generate full sentence for keperluan

            // Truncate keperluan to 50 characters if it exceeds
            if (strlen($keperluan) > 50) {
                $keperluan = substr($keperluan, 0, 50);
            }

            // Generate pengajuan edit data warga with 10% chance
            if (rand(0, 4) === 0) {
                $pengajuanSuratPengantar[] = [
                    'NIK' => $warga['NIK'],
                    'pekerjaan' => $faker->jobTitle,
                    'pendidikan' => $faker->randomElement(['SMP', 'SMA', 'D3', 'S1', 'S2', 'S3']),
                    'no_hp' => $faker->phoneNumber,
                    'keperluan' => $keperluan, // Use truncated keterangan
                    'status' =>  $faker->randomElement(['proses', 'selesai', 'ditolak']), // Use truncated keterangan
                ];
            }
        }
        DB::table('pengajuansuratpengantar')->insert($pengajuanSuratPengantar);

        $keluargaKurangMampuData = [];
        foreach ($keluargaData as $keluarga) {
            if (rand(0, 8) === 0) {
                $keluargaKurangMampuData[] = [
                    'noKK' => $keluarga['noKK'],
                    'jumlah_tanggungan' => $faker->numberBetween(1, 5),
                    'pendapatan' => $faker->randomFloat(2, 10000, 20000),
                    'aset_kendaraan' => $faker->randomFloat(2, 10000, 20000),
                    'luas_tanah' => $faker->numberBetween(100, 500),
                    'kondisi_rumah' => $faker->numberBetween(1, 5),
                    'status' =>  $faker->randomElement(['proses', 'selesai', 'ditolak']),
                    'no_hp' => $faker->phoneNumber,
                ];
            }
        }
        DB::table('pengajuanprasejahtera')->insert($keluargaKurangMampuData);

        $galeriData = [];
        for ($i = 0; $i < 10; $i++) {
            $galeriData[] = [
                'nama_foto' => $faker->word . '.jpg', // contoh nama file foto, Anda bisa menyesuaikan sesuai kebutuhan
                'judul' => $faker->sentence,
                'tanggal_kegiatan' => $faker->date('Y-m-d'),
                'keterangan' => $faker->sentence,
            ];
        }

        DB::table('galeri')->insert($galeriData);

        $userAccount = [];
        foreach ($wargaData as $warga) {
            if ($warga['status_keluarga'] == 'kepala keluarga') {
                $userAccount[] = [
                    'level' => 'warga',
                    'nama' => $warga['nama'],
                    'username' => $warga['NIK'],
                    'password' => Hash::make($warga['NIK']),
                ];
            }
        }
        DB::table('users')->insert($userAccount);

        DB::table('users')->insert([
            'username' => 'admin',
            'level' => 'admin',
            'nama' => 'Admin',
            'password' => Hash::make('admin'), // sesuaikan dengan password yang diinginkan
        ]);

        // Seeder for superadmin user
        DB::table('users')->insert([
            'username' => 'superadmin',
            'level' => 'superadmin',
            'nama' => 'Superadmin',
            'password' => Hash::make('superadmin'), // sesuaikan dengan password yang diinginkan
        ]);

        //seeder criteria ps
        $criteria = [
            [
                'kode' => 'C1',
                'nama' => 'Pendapatan',
                'bobot' => 4,
                'jenis' => 'Benefit',
            ],
            [
                'kode' => 'C2',
                'nama' => 'Jumlah Tanggungan',
                'bobot' => 6,
                'jenis' => 'Cost',
            ],
            [
                'kode' => 'C3',
                'nama' => 'Aset Kendaraan',
                'bobot' => 5,
                'jenis' => 'Cost',
            ],
            [
                'kode' => 'C4',
                'nama' => 'Luas tanah',
                'bobot' => 3,
                'jenis' => 'Cost',
            ],
            [
                'kode' => 'C5',
                'nama' => 'Kondisi Rumah',
                'bobot' => 2,
                'jenis' => 'Cost',
            ],
        ];

        DB::table('criteriaprasejahtera')->insert($criteria);
    }
}
