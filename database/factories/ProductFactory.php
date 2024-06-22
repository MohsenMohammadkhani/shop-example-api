<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Permission>
 */
class ProductFactory extends Factory
{

    protected $model = Product::class;

    private static $order = 0;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        self::$order++;
        return [
            'title' => "title-" . self::$order,
            'slug' => "slug-" . self::$order,
            'price' => rand(pow(10, 4), pow(10, 5))
        ];
    }
}
