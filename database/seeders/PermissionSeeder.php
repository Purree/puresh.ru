<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    protected array $permissions = ['is_admin', 'notes', 'events', 'randomize'];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->permissions as $permission) {
            Permission::factory()
                ->create(['name' => $permission]);
        }
    }
}
