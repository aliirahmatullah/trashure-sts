<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id('id_lokasi');
            $table->string('nama_lok', 100);
            $table->text('alamat_lok')->nullable();
            $table->string('kota', 100);
            $table->string('provinsi', 100);
            $table->string('kontak_lok', 50)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
