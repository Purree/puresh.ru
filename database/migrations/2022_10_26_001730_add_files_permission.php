<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
