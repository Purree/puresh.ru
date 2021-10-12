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

    private array $userPermissions = [];

    /**
     * Generate array with permissions what user will have
     *
     * @throws Exception
     */
    public function generateAndUpdateUserPermissionsArray(): array
    {
        $userPermissions = [];
        foreach (Permission::getAll() as $permission) {
            $userPermissions[$permission] = random_int(0, 1);
        }
        $this->userPermissions = $userPermissions;
        return $userPermissions;
    }

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws Exception
     */
    public function definition(): array
    {
        $permissions = $this->userPermissions ?? $this->generateAndUpdateUserPermissionsArray();
        return array_merge([
            'user_id' => User::factory(),
        ], $permissions);
    }
}

