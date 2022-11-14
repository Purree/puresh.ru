<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', static function (Blueprint $table) {
            $table->string('vk_token', 1024)->nullable();
            $table->bigInteger('vk_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', static function (Blueprint $table) {
            $table->dropColumn('vk_access_token');
            $table->dropColumn('vk_id');
        });
    }
};
