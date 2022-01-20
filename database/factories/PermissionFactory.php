<?php

namespace Database\Factories;

use App\Models\Permission;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

class PermissionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Permission::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->text
        ];
    }
}

