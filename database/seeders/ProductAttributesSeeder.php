<?php

namespace Database\Seeders;

use App\Models\ProductAttributes;
use Illuminate\Database\Seeder;

class ProductAttributesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductAttributes::factory()
            ->count(50)
            ->create();
    }
}
