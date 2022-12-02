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
        Schema::create('m_r_p_s', function (Blueprint $table) {
            $table->id('ID_MRP');
            $table->string('Kode_MRP');
            $table->bigInteger('MPS_ID')->unsigned();
            $table->bigInteger('Produk_ID')->unsigned();
            $table->bigInteger('BOM_ID')->unsigned()->nullable();
            $table->date('Tanggal_Pesan');
            $table->date('Tanggal_Selesai');
            $table->integer('GR')->nullable();
            $table->integer('SR')->nullable();
            $table->integer('OHI')->nullable();
            $table->integer('NR')->nullable();
            $table->integer('POR')->nullable();
            $table->integer('POREL')->nullable();
            $table->string('status');
            $table->timestamps();
        });
        Schema::table('m_r_p_s', function (Blueprint $table) {

            $table->foreign('MPS_ID')
                ->references('ID_MPS')
                ->on('m_p_s')
                ->onDelete('cascade');
        });
        Schema::table('m_r_p_s', function (Blueprint $table) {
            $table->foreign('Produk_ID')
                ->references('ID_Produk')
                ->on('produks')
                ->onDelete('cascade');
        });
        Schema::table('m_r_p_s', function (Blueprint $table) {
            $table->foreign('BOM_ID')
                ->references('ID_BOM')
                ->on('boms')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('m_r_p_s');
    }
};
