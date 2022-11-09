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
        Schema::create('bahan_bakus', function (Blueprint $table) {
            $table->id('ID_BahanBaku');
            $table->string('Kode_BahanBaku');
            $table->bigInteger('Supplier_ID')->unsigned();
            $table->string('Nama_BahanBaku');
            $table->string('Satuan_BahanBaku');
            $table->integer('Leadtime_BahanBaku');
            $table->integer('Stok_BahanBaku');
            $table->float('Harga_Satuan');
            $table->timestamps();
        });
        Schema::table('bahan_bakus', function (Blueprint $table) {
            $table->foreign('Supplier_ID')->references('ID_Supplier')->on('suppliers')->onDelete('cascade');
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
        Schema::dropIfExists('bahan_bakus');

    }
};
