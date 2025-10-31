<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('waste_types', function (Blueprint $table) {
            $table->id('id_jenis'); // primary key

            // hapus foreign key ke waste_categories
            $table->string('kategori', 50); // kategori sebagai string, sesuai model

            $table->string('nama_jenis', 100);
            $table->text('deskripsi_jenis')->nullable(); // sesuaikan nama field model
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('waste_types');
    }
};
