<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Old product_addons table is dropped in create_product_addons_table migration
        // This migration exists for clarity and rollback purposes
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback handled in create_product_addons_table migration
    }
};
