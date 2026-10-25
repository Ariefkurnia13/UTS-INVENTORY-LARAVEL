<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $elektronik = Category::where('name', 'Elektronik')->firstOrFail();
        $alatTulis = Category::where('name', 'Alat Tulis')->firstOrFail();

        Product::firstOrCreate(
            ['sku' => 'ELK-001'],
            [
                'category_id' => $elektronik->id,
                'name' => 'Mouse Wireless',
                'quantity' => 15,
                'price' => 125000,
                'description' => 'Mouse wireless untuk komputer',
            ]
        );

        Product::firstOrCreate(
            ['sku' => 'ATK-001'],
            [
                'category_id' => $alatTulis->id,
                'name' => 'Buku Tulis',
                'quantity' => 50,
                'price' => 5000,
                'description' => 'Buku tulis standar',
            ]
        );
    }
}
