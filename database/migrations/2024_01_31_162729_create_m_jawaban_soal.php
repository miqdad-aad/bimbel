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
        Schema::create('m_jawaban_soal', function (Blueprint $table) {
            $table->increments('id_jawaban_soal');
            $table->integer('id_soal');
            $table->char('kode_jawaban');
            $table->text('keterangan');
            $table->text('file_tambahan');
            $table->dateTime('deleted_at');
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
        Schema::dropIfExists('m_jawaban_soal');
    }
};
