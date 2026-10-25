<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::firstOrCreate(
            ['name' => 'Elektronik'],
            ['description' => 'Peralatan elektronik']
        );

        Category::firstOrCreate(
            ['name' => 'Alat Tulis'],
            ['description' => 'Perlengkapan alat tulis']
        );

        Category::firstOrCreate(
            ['name' => 'Aksesori'],
            ['description' => 'Aksesori dan perlengkapan']
        );
    }
}
