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
        Schema::create('m_paket', function (Blueprint $table) {
            $table->increments('id_paket');
            $table->char('nama_paket');
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 20,2)->nullable();
            $table->text('gambar')->nullable();
            $table->dateTime('deleted_at')->nullable();
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
        Schema::dropIfExists('m_paket');
    }
};
