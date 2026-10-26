<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        Supplier::firstOrCreate(
            ['email' => 'supplier.demo@example.com'],
            [
                'name' => 'Supplier Demo',
                'contact_person' => 'Kontak Demo',
                'phone' => '080000000000',
                'address' => 'Alamat Demo',
                'is_active' => true,
            ]
        );
    }
}
