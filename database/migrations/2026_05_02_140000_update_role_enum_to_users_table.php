<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Delete any existing users with invalid roles before changing enum
        DB::table('users')->whereNotIn('role', ['admin', 'manager', 'cleaner'])->delete();
        
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'supervisor', 'housekeeper'])->default('housekeeper')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Delete any existing users with the new roles before reverting
        DB::table('users')->whereNotIn('role', ['admin'])->delete();
        
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'manager', 'cleaner'])->default('cleaner')->change();
        });
    }
};
