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
        Schema::create('m_p_s', function (Blueprint $table) {
            $table->id('ID_MPS');
            $table->string('Kode_MPS');
            $table->bigInteger('Produk_ID')->unsigned();
            $table->string('Ukuran_Produk');
            $table->integer('Jumlah_MPS');
            $table->date('Tanggal_MPS');
            $table->timestamps();
        });
        Schema::table('m_p_s', function (Blueprint $table) {
            $table->foreign('Produk_ID')->references('ID_Produk')->on('produks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_p_s');
    }
};
