<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MRP extends Model
{
    protected $primaryKey = 'ID_MRP';
    protected $guarded = ['ID_MRP', 'timestamps'];
    protected $fillable = [
        'Kode_MRP',
        'MPS_ID',
        'Produk_ID',
        'BOM_ID',
        'Tanggal_Pesan',
        'Tanggal_Selesai',
        'GR',
        'SR',
        'OHI',
        'NR',
        'POR',
        'POREL',
        'status',
    ];

    public function Produk()
    {
        return $this->belongsTo(Produk::class, 'Produk_ID');
    }
    public function MPS()
    {
        return $this->belongsTo(MPS::class, 'MPS_ID');
    }
    public function BOM()
    {
        return $this->belongsTo(BOM::class, 'BOM_ID');
    }
    public function Payments()
    {
        return $this->hasOne(Payments::class);
    }
}
