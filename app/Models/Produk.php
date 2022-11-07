<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_Produk';
    protected $fillable =[
        'Nama_Produk', 
        'Ukuran_Produk', 
        'Jumlah_Produk'];

    public function BOM()
    {
       return $this->hasOne(Bom::class);
    }
    public function MPS()
    {
       return $this->hasOne(MPS::class);
    }
}
