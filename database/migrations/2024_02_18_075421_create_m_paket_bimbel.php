<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_paket_bimbel', function (Blueprint $table) {
            $table->increments('id_paket_bimbel');
            $table->char('nama_paket_bimbel');
            $table->text('deskripsi_paket');
            $table->decimal('harga_paket_bimbel');
            $table->decimal('kuota_peserta');
            $table->char('status_aktif');
            $table->datetime('tanggal_mulai');
            $table->datetime('tanggal_selesai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_paket_bimbel');
    }
};
