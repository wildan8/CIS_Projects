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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id('ID_Supplier'); 
            $table->string('Kode_Supplier'); 
            $table->string('Nama_Supplier');
            $table->string('Pemilik_Supplier');           
            $table->string('Alamat_Supplier');
            $table->string('Telp_Supplier');
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('suppliers');
    }
};
