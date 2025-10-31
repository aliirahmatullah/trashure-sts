<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reward_redemptions', function (Blueprint $table) {
            $table->id('id_tukar');

            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')
                  ->references('id_user')
                  ->on('users')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('id_hadiah');
            $table->foreign('id_hadiah')
                  ->references('id_hadiah')
                  ->on('rewards')
                  ->onDelete('cascade');

            $table->integer('jumlah_hadiah');
            $table->date('tanggal_tukar')->nullable();
            $table->enum('status_tukar', ['pending','approved','done'])->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reward_redemptions');
    }
};
