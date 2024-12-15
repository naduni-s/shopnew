<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Decant;

class DecantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Decant::insert([
            ['name' => 'Chanel Bleu de Chanel ', 'price' => 1250.00],
            ['name' => 'Dior Sauvage', 'price' => 1500.00],
            ['name' => 'Creed Aventus', 'price' => 800.00],
            ['name' => 'Tom Ford Tobacco Vanille ', 'price' => 500.00],
            ['name' => 'Jo Malone Lime Basil & Mandarin ', 'price' => 1255.00],
            ['name' => 'YSL Black Opium ', 'price' => 1850.00],
            ['name' => 'Maison Francis Kurkdjian Baccarat Rouge 540 ', 'price' => 2000.00],
            ['name' => 'Versace Eros ', 'price' => 3000.00],
            ['name' => 'Armani Acqua di Gio Profumo ', 'price' => 2450.00],
            ['name' => 'Le Labo Santal 33 ', 'price' => 1750.00],
        ]);
    }
}
