<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->foreignId('owner_id')
                  ->nullable()
                  ->after('id')
                  ->constrained('users')
                  ->onDelete('cascade');
        });
    
        DB::statement('UPDATE reservations SET owner_id = user_id WHERE user_id IS NOT NULL');
    
        if (DB::table('reservations')->whereNull('owner_id')->exists()) {
            throw new \Exception('Cannot set NOT NULL: owner_id still contains NULL values');
        }
    
        Schema::table('reservations', function (Blueprint $table) {
            $table->foreignId('owner_id')->nullable(false)->change();
        });
    }
    

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropForeign(['owner_id']);
            $table->dropColumn('owner_id');
        });
    }
};
