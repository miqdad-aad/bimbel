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
        Schema::create('m_pembelajaran', function (Blueprint $table) {
            $table->id();
            $table->char('uraian_materi');
            $table->text('link_video')->nullable();
            $table->text('link_materi')->nullable();
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
        Schema::dropIfExists('m_pembelajaran');
    }
};
