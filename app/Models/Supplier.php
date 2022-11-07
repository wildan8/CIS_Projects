<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
     protected $primaryKey = 'ID_Supplier';
     protected $fillable = ['Kode_Supplier','Nama_Supplier', 'Pemilik_Supplier', 'Alamat_Supplier', 'Telp_Supplier'];
     public function BahanBaku()
     {
        return $this->hasMany(BahanBaku::class);
     }

    
}
