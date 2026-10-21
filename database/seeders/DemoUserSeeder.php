<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        // Set credentials only in local .env (never commit .env).
        $adminEmail = env('DEMO_ADMIN_EMAIL');
        $adminPassword = env('DEMO_ADMIN_PASSWORD');
        $staffEmail = env('DEMO_STAFF_EMAIL');
        $staffPassword = env('DEMO_STAFF_PASSWORD');

        if (! $adminEmail || ! $adminPassword || ! $staffEmail || ! $staffPassword) {
            throw new RuntimeException('Isi DEMO_ADMIN_EMAIL, DEMO_ADMIN_PASSWORD, DEMO_STAFF_EMAIL, DEMO_STAFF_PASSWORD di .env sebelum menjalankan DemoUserSeeder.');
        }

        if ($adminEmail === $staffEmail) {
            throw new RuntimeException('Email demo Admin dan Staff harus berbeda.');
        }

        foreach ([
            ['name' => 'Demo Admin', 'email' => $adminEmail, 'password' => $adminPassword, 'role' => 'admin'],
            ['name' => 'Demo Staff', 'email' => $staffEmail, 'password' => $staffPassword, 'role' => 'staff'],
        ] as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                ['name' => $user['name'], 'role' => $user['role'], 'password' => Hash::make($user['password'])]
            );
        }
    }
}
