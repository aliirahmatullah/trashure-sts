<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 1️⃣ Hapus kolom alamat
            if (Schema::hasColumn('users', 'alamat')) {
                $table->dropColumn('alamat');
            }

            // 2️⃣ Tambahkan kolom id_lokasi (nullable dulu untuk keamanan)
            $table->unsignedBigInteger('id_lokasi')->nullable()->after('no_hp');

            // 3️⃣ Tambahkan relasi foreign key
            $table->foreign('id_lokasi')
                  ->references('id_lokasi')
                  ->on('locations')
                  ->onDelete('set null'); // agar jika lokasi dihapus, user tidak ikut terhapus
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // rollback: hapus foreign key & kolom id_lokasi, lalu tambahkan kolom alamat kembali
            $table->dropForeign(['id_lokasi']);
            $table->dropColumn('id_lokasi');
            $table->text('alamat')->nullable()->after('password');
        });
    }
};
