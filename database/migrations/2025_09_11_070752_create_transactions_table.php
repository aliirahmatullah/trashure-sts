<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->string('no_transaksi')->unique();

            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')
                  ->references('id_user')
                  ->on('users')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('id_jenis');
            $table->foreign('id_jenis')
                  ->references('id_jenis')
                  ->on('waste_types')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('id_lokasi');
            $table->foreign('id_lokasi')
                  ->references('id_lokasi')
                  ->on('locations')
                  ->onDelete('cascade');

            $table->decimal('berat', 8, 2);
            $table->integer('poin_didapat');
            $table->date('tanggal');
            $table->enum('status', ['pending','approved','completed','canceled'])->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
