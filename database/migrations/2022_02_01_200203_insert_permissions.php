<?php

use Illuminate\Database\Migrations\Migration;

class InsertPermissions extends Migration
{
    protected array $permissions = ['is_admin', 'notes', 'events', 'randomize'];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->permissions as $permission) {
            DB::table('permissions')->insert(
                [
                    'name' => $permission,
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('permissions')->delete();
    }
}
