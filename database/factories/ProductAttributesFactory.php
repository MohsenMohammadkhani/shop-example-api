<?php

namespace Database\Factories;

use App\Models\ProductAttributes;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductAttributes>
 */
class ProductAttributesFactory extends Factory
{
    protected $model = ProductAttributes::class;

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
            "images_path" => [
                "public/products/1717953447-1.webp",
                "public/products/1717953447-2.webp",
                "public/products/1717953447-3.webp"
            ],
            "product_id" => self::$order,
            "width" => "300",
            "height" => "500",
            "weight" => "800"
        ];
    }
}
