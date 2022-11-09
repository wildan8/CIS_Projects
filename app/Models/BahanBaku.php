<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_BahanBaku';
    protected $guarded = ['ID_BahanBaku', 'timestamps'];
    protected $fillable = ['Nama_BahanBaku', 'Kode_BahanBaku', 'Stok_BahanBaku', 'Satuan_BahanBaku', 'Leadtime_BahanBaku', 'Harga_Satuan', 'Supplier_ID'];

    public function Supplier()
    {
        return $this->belongsTo(Supplier::class, 'Supplier_ID');
    }
    public function Penerimaan()
    {
        return $this->hasOne(Penerimaan::class);
    }

    public function BOM()
    {
        return $this->hasOne(BOM::class);
    }
}
