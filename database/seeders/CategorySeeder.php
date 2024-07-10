<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'title' => 'wedding',
            'image' => 'categories/wedding.jpg'
        ]);

        Category::create([
            'title' => 'engagement',
            'image' => 'categories/tunangan.jpg'
        ]);

        Category::create([
            'title' => 'birthday',
            'image' => 'categories/ulangtahun.jpg'
        ]);

        Category::create([
            'title' => 'others',
            'image' => 'categories/khitan.jpg'
        ]);

        Category::create([
            'title' => 'hardware',
            'image' => 'categories/sLATQr72yKLRAbDeXM9PZoXZphYl0VfErif0kZGS.jpg'
        ]);
    }
}
