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
        Schema::create('payments', function (Blueprint $table) {
            $table->id('ID_Payment');
            $table->string('Kode_Payment');
            $table->bigInteger('MRP_ID')->unsigned();
            $table->float('Harga_Payment')->default(0);
            $table->date('Tanggal_Payment');
            $table->timestamps();
        });
        Schema::table('payments', function (Blueprint $table) {

            $table->foreign('MRP_ID')
                ->references('ID_MRP')
                ->on('m_r_p_s')
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
        Schema::dropIfExists('payments');
    }
};
