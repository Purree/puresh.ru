<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        DB::table('permissions')->insert(
            [
                'name' => 'files',
            ]
        );
    }

    public function down(): void
    {
        DB::table('permissions')->where('name', 'files')->delete();
    }
};
