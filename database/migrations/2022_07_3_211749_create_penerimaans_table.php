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
        Schema::create('penerimaans', function (Blueprint $table) {
            $table->id('ID_LOG');
            $table->string('Kode_LOG');
            $table->bigInteger('BahanBaku_ID')->unsigned();
            $table->integer('Jumlah_LOG');
            $table->date('Tanggal_LOG');
            $table->string('Status_LOG');
            $table->timestamps();
        });
        Schema::table('penerimaans',function (Blueprint $table){
            
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
        // Schema::table('penerimaans', function (Blueprint $table) {
        //     $table->dropForeign('penerimaans_bahanbaku_id_foreign');
        //     $table->dropColumn('BahanBaku_ID');
        // });
        Schema::dropIfExists('penerimaans');
    }
};
