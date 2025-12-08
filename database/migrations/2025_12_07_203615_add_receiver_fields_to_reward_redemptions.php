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
        Schema::table('reward_redemptions', function (Blueprint $table) {
            $table->string('nama_penerima')->after('status_tukar');
            $table->text('alamat_pengiriman')->after('nama_penerima');
            $table->string('no_hp_penerima', 20)->after('alamat_pengiriman');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reward_redemptions', function (Blueprint $table) {
            $table->dropColumn([
                'nama_penerima',
                'alamat_pengiriman',
                'no_hp_penerima',
            ]);
        });
    }
};
