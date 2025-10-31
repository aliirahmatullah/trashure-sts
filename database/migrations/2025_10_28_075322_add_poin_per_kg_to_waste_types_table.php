<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('waste_types', function (Blueprint $table) {
            $table->integer('poin_per_kg')->default(0)->after('nama_jenis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('waste_types', function (Blueprint $table) {
            $table->dropColumn('poin_per_kg');
        });
    }
};
