<?php

namespace App\Exports;

use App\Exports\ExcelMRP;
use App\Models\MPS;
use App\Models\MRP;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExcelMRP implements FromView, ShouldAutoSize
{
    use Exportable;

    public function forDate($daterange)
    {
        $this->daterange = $daterange;

        return $this;
    }
    public function view(): View
    {
        $date = explode('+', $this->daterange); //EXPLODE TANGGALNYA UNTUK MEMISAHKAN START & END
        //DEFINISIKAN VARIABLENYA DENGAN FORMAT TIMESTAMPS
        $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
        $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';
        $jenis = 'ALLMRP';
        $Judul = $jenis . ' ALL LIST';
        $Tanggal = date('Y-m-d H:i:s');
        //KEMUDIAN BUAT QUERY BERDASARKAN RANGE CREATED_AT YANG TELAH DITETAPKAN RANGENYA DARI $START KE $END
        $mrp_etc = MRP::orderBy("Tanggal_pesan")->get();
        // dd($mrp_etc);

        $mrp_BB = DB::table('m_r_p_s')
            ->join('m_p_s', 'm_p_s.ID_MPS', '=', 'm_r_p_s.MPS_ID')
            ->join('boms', 'boms.ID_BOM', '=', 'm_r_p_s.BOM_ID')
            ->join('bahan_bakus', 'bahan_bakus.ID_BahanBaku', '=', 'boms.BahanBaku_ID')
            ->select(
                DB::raw('SUM(m_r_p_s.POREL) as sum_POREL'),
                'm_p_s.ID_MPS',
                'm_r_p_s.MPS_ID',
                'm_r_p_s.Produk_ID',
                'm_r_p_s.BOM_ID',
                'm_r_p_s.Tanggal_Pesan',
                'm_r_p_s.Tanggal_Selesai',
                'm_r_p_s.status',
                'boms.BahanBaku_ID',
                'boms.Level_BOM',
                'bahan_bakus.Nama_BahanBaku',
                'bahan_bakus.satuan_BahanBaku'
            )
            ->groupBy('bahan_bakus.Nama_BahanBaku')
            ->groupBy('m_p_s.ID_MPS')
            ->get();
        // dd($mrp_BB);

        $mpsON = MPS::with('Produk')->whereBetween('Tanggal_MPS', [$start, $end])->get();
        return view('Laporan.ExcelFormat', compact('mrp_BB', 'mrp_etc', 'mpsON', 'Judul', 'Tanggal', 'jenis', 'start', 'end'));
        // $pdf = PDF::loadView('Laporan.MRPAll', compact('mrp_BB', 'mrp_etc', 'mpsON', 'Judul', 'Tanggal', 'jenis', 'start', 'end'))->setOptions(['defaultFont' => 'sans-serif']);
    }
}
