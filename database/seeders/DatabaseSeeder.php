<?php

namespace Database\Seeders;

use App\Models\FamilyModel;
use App\Models\ResidentModel;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat data FamilyModel terlebih dahulu
        FamilyModel::factory(7)->create();

        // Membuat data ResidentModel setelah data FamilyModel sudah dibuat
        ResidentModel::factory(30)->create();
    }
}
