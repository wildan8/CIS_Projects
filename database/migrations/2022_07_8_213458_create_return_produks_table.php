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
        Schema::create('return_produks', function (Blueprint $table) {
            $table->id('ID_ReturnProduk');
            $table->integer('Jumlah_ReturnProduk');
            $table->date('Tanggal_ReturnProduk');
            $table->boolean('Status_ReturnProduk');
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
        Schema::dropIfExists('return_produks');
    }
};
