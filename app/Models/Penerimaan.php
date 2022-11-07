<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penerimaan extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_LOG';
    protected $guarded =['ID_LOG', 'timestamps'];
    protected $fillable =['Kode_LOG','BahanBaku_ID','Jumlah_LOG','Tanggal_LOG','Status_LOG'];
    
    public function BahanBaku()
     {
        return $this->belongsTo(BahanBaku::class, 'BahanBaku_ID');
     }
}
