<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql' || $driver === 'mariadb') {
            // MySQL/MariaDB: pakai ALTER TABLE MODIFY COLUMN
            DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending','confirmed','processing','delivered','completed','cancelled') NOT NULL DEFAULT 'pending'");
        }
        // SQLite tidak support ENUM — tapi SQLite sudah menyimpan status sebagai string
        // sehingga nilai 'completed' bisa langsung disimpan tanpa perlu alter table
    }

    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql' || $driver === 'mariadb') {
            DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending','confirmed','processing','delivered','cancelled') NOT NULL DEFAULT 'pending'");
        }
    }
};
