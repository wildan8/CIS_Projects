<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_Payment';
    protected $guarded = ['ID_Payment', 'timestamps'];
    public $timestamps = true;
    protected $fillable = ['MRP_ID', 'Kode_Payment', 'Harga_Payment', 'Tanggal_Payment'];

    public function MRP()
    {
        return $this->belongsTo(MRP::class, 'MRP_ID');
    }
}
