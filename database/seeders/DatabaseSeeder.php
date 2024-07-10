<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::create([
            'first_name' => 'charles',
            'last_name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
            'role' => 'admin',
            'admin' => 1
        ]);
        User::create([
            'first_name' => 'charles',
            'last_name' => 'vendor',
            'email' => 'vendor@gmail.com',
            'password' => Hash::make('vendor123'),
            'email_verified_at' => now(),
            'role' => 'vendor',
            'admin' => 1
        ]);

        User::create([
            'first_name' => 'john',
            'last_name' => 'wick',
            'email' => 'john@gmail.com',
            'password' => Hash::make('john123'),
            'email_verified_at' => now(),
            'role' => 'customer',
        ]);

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
