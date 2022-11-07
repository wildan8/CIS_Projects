<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bom extends Model
{
    use HasFactory;
    protected $primaryKey = "ID_BOM";
    protected $guarded = ['ID_BOM', 'timestamps'];
    protected $fillable = ['Kode_BOM', 'Produk_ID', 'BahanBaku_ID', 'Ukuran_Produk', 'Jumlah_Produk'];

    public function Produk()
     {
        return $this->belongsTo(Produk::class, 'Produk_ID');
     }

     public function BahanBaku()
     {
        return $this->belongsTo(BahanBaku::class, 'BahanBaku_ID');
     }
}
