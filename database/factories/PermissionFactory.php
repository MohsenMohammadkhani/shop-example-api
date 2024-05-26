<?php

namespace Database\Factories;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Permission>
 */
class PermissionFactory extends Factory
{

    protected $model = Permission::class;

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
            'name' => "name-" . self::$order,
            'persian_name' => "persian-name-" . self::$order,
        ];
    }
}
