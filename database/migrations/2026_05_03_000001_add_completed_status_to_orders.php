<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Alter enum langsung — cara paling aman untuk MySQL
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending','confirmed','processing','delivered','completed','cancelled') NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending','confirmed','processing','delivered','cancelled') NOT NULL DEFAULT 'pending'");
    }
};
