<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (\Illuminate\Support\Facades\DB::getDriverName() === 'mysql') {
            \Illuminate\Support\Facades\DB::statement("
                ALTER TABLE `promotions`
                MODIFY `status` ENUM('pending','active','expired','inactive') NOT NULL DEFAULT 'pending'
            ");
        }
        // En SQLite, no hacer nada (ignorar)
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        if (\Illuminate\Support\Facades\DB::getDriverName() === 'mysql') {
            \Illuminate\Support\Facades\DB::statement("
                ALTER TABLE `promotions`
                MODIFY `status` ENUM('pending','active','expired','inactive') NOT NULL DEFAULT 'pending'
            ");
        }
        // En SQLite, no hacer nada (ignorar)
    }
};
