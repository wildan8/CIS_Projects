<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MPS extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_MPS';
    protected $guarded = ['ID_MPS', 'timestamps'];
    protected $fillable = ['Kode_MPS', 'Produk_ID', 'Ukuran_Produk', 'Jumlah_MPS', 'Tanggal_MPS'];

    public function Produk()
    {
        return $this->belongsTo(Produk::class, 'Produk_ID');
    }
}
