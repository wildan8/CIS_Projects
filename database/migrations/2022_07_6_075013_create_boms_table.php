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
        Schema::create('boms', function (Blueprint $table) {
            $table->id('ID_BOM');
            $table->string('Kode_BOM');
            $table->bigInteger('Produk_ID')->unsigned();
            $table->bigInteger('BahanBaku_ID')->unsigned();            
            $table->string('Ukuran_Produk');
            $table->integer('Jumlah_BOM');
            $table->timestamps();
        });
        Schema::table('boms',function (Blueprint $table){
            
            $table->foreign('Produk_ID')
                ->references('ID_Produk')
                ->on('produks')
                ->onDelete('cascade');
           });
           Schema::table('boms',function (Blueprint $table){
            
            $table->foreign('BahanBaku_ID')
                ->references('ID_BahanBaku')
                ->on('bahan_Bakus')
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
       
        Schema::dropIfExists('boms');
    }
};
