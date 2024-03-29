<?php

namespace App\Http\Controllers;

use App\Exports\ExcelMRP;
use App\Helpers\Helper;
use App\Models\BahanBaku;
use App\Models\BOM;
use App\Models\MPS;
use App\Models\MRP;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class mrpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $mpsW = MPS::with('Produk')->where('status', '=', 'waiting')->paginate(10);
        $mpsON = MPS::with('Produk')->where('status', '!=', 'Waiting')->paginate(10);
        $mrp = MRP::with('MPS', 'Produk', 'BOM')->paginate(10);

        return view('Admin.tabel.MRP', compact('mpsW', 'mpsON', 'mrp'));
    }
    public function ExcelMRP($daterange)
    {
        return (new ExcelMRP)->forDate($daterange)->download('ExcelMRP ( ' . date('Y-m-d H:i:s') . ' ).xlsx');
    }
    public function filter()
    {
        $start = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
        $end = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');
        if (request()->date != '') {
            $date = explode(' - ', request()->date);
            $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
            $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';
        }
        $mpsON = DB::table('m_r_p_s')
            ->join('m_p_s', 'm_p_s.ID_MPS', '=', 'm_r_p_s.MPS_ID')
            ->join('produks', 'produks.ID_PRODUK', '=', 'm_r_p_s.PRODUK_ID')

            ->select(
                'm_p_s.ID_MPS',
                'm_p_s.Kode_MPS',
                'm_p_s.Tanggal_MPS',
                'm_p_s.Jumlah_MPS',
                'm_r_p_s.POREL',
                'm_r_p_s.MPS_ID',
                'm_r_p_s.Produk_ID',
                'm_r_p_s.BOM_ID',
                'm_r_p_s.Tanggal_Pesan',
                'm_r_p_s.Tanggal_Selesai',
                'm_p_s.status',
                'produks.Nama_Produk',
                'produks.Ukuran_Produk',

            )
            ->where('m_p_s.status', '!=', 'Waiting')
            ->where('m_r_p_s.BOM_ID', '=', null)
            ->whereBetween('m_p_s.Tanggal_MPS', [$start, $end])
            ->paginate(10);
        return view('Admin.tabel.filterMRP', compact('mpsON'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, MPS $ID_MPS)
    {

        $Find_Produk = Produk::where("ID_Produk", $ID_MPS->Produk_ID)
            ->first();
        // echo $Find_Produk;
        $BOM = BOM::where('Kode_BOM', 'like', '%BB' . $Find_Produk->ID_Produk . $Find_Produk->Ukuran_Produk . '%')
            ->orWhere('Kode_BOM', 'like', '%P' . $Find_Produk->ID_Produk . $Find_Produk->Ukuran_Produk . '%')
            ->orderBy("Tipe_BOM")->get();
        // echo '<br> test' . $BOM;
        $Kode_MRP = Helper::IDGenerator(new MRP, 'ID_MRP', 'Kode_MRP', 2, 'MRP-' . $Find_Produk->ID_Produk . $Find_Produk->Ukuran_Produk . $ID_MPS->ID_MPS . '-');

        foreach ($BOM as $Bo) {
            if ($Bo->Tipe_BOM == "BahanBaku") {
                $BB = BahanBaku::where('ID_BahanBaku', '=', $Bo->BahanBaku_ID)->first();
                $NR = $POR = $POREL = $GR = $Bo->Jumlah_BOM * $ID_MPS->Jumlah_MPS;
                $OHI = 0;
                $dateStart = $ID_MPS->Tanggal_MPS;
                $count = 0;
                $itung = $GR;
                $maks = 180;
                $x = true;

                while ($x == true) {
                    if ($itung <= $maks&$itung >= 0) {
                        $x = false;
                        $count = $count + 1;
                    } elseif ($itung > $maks) {
                        $x = true;
                        $count = $count + 1;
                        $itung = $itung - $maks;
                    }
                }
                $count = $BB->Leadtime_BahanBaku * $count;
                $dateDone = date('Y-m-d', strtotime('+' . $count . ' days', strtotime($ID_MPS->Tanggal_MPS)));

            } elseif ($Bo->Tipe_BOM == "Parts") {
                $cek = BOM::where('Nama_Part', '=', $Bo->Nama_Part)
                    ->where('Tipe_BOM', '=', 'BahanBaku')->count();
                $BB = BOM::where('Nama_Part', '=', $Bo->Nama_Part)
                    ->where('Tipe_BOM', '=', 'BahanBaku')->first();
                $late = MRP::where('Kode_MRP', '=', $Kode_MRP)->orderByDesc('Tanggal_Selesai')->first();
                $count = 0;
                $itung = $GR;
                $maks = 200;
                $x = true;
                while ($x == true) {
                    if ($itung <= $maks&$itung >= 0) {
                        $x = false;
                        $count = $count + 1;
                    } elseif ($itung > $maks) {
                        $x = true;
                        $count = $count + 1;
                        $itung = $itung - $maks;
                    }
                }
                $count = $Bo->Leadtime_BOM * $count;
                if ($cek == 0) {

                } else {

                    $Bu = BahanBaku::where('ID_BahanBaku', '=', $BB->BahanBaku_ID)->first();
                    $NR = $POR = $POREL = $GR = $Bo->Jumlah_BOM * $ID_MPS->Jumlah_MPS;

                    $OHI = 0;
                    $dateStart = $late->Tanggal_Selesai;
                    $dateDone = date('Y-m-d', strtotime('+' . $count . ' days', strtotime($late->Tanggal_Selesai)));

                }
            } else {
                return redirect('/MRP')->with('nullMRP', 'Perhitungan MRP Gagal! isi BOM terlebih dahulu!');
            }
            MRP::insert([
                'Kode_MRP' => $Kode_MRP,
                'MPS_ID' => $ID_MPS->ID_MPS,
                'Produk_ID' => $Find_Produk->ID_Produk,
                'BOM_ID' => $Bo->ID_BOM,
                'Tanggal_Pesan' => $dateStart,
                'Tanggal_Selesai' => $dateDone,
                'GR' => $GR,
                'SR' => 0,
                'OHI' => 0,
                'NR' => $NR,
                'POR' => $POR,
                'POREL' => $POREL,
                'status' => 'On-Progress',
            ]);

        }
        // MRP Produk
        $count = 0;
        $itung = $ID_MPS->Jumlah_MPS;
        $maks = 200;
        $x = true;
        while ($x == true) {
            if ($itung <= $maks&$itung >= 0) {
                $x = false;
                $count = $count + 1;
            } elseif ($itung > $maks) {
                $x = true;
                $count = $count + 1;
                $itung = $itung - $maks;
            }

        }

        $count = $Find_Produk->Leadtime_Assembly * $count;
        $late = MRP::where('Kode_MRP', '=', $Kode_MRP)->orderByDesc('Tanggal_Selesai')->first();
        if ($late == null) {
            return redirect('/MRP')->with('nullMRP', 'Perhitungan MRP Gagal! isi BOM terlebih dahulu!');
        } else {
            // dd($late);
            $date = date('Y-m-d', strtotime('+' . $count . ' days', strtotime($late->Tanggal_Selesai)));
            DB::table('m_p_s')
                ->where('ID_MPS', $ID_MPS->ID_MPS)
                ->update([
                    'status' => 'On-Progress',
                ]);
            MRP::insert([
                'Kode_MRP' => $Kode_MRP,
                'MPS_ID' => $ID_MPS->ID_MPS,
                'Produk_ID' => $Find_Produk->ID_Produk,
                'Tanggal_Pesan' => $late->Tanggal_Selesai,
                'Tanggal_Selesai' => $date,
                'GR' => $GR,
                'SR' => 0,
                'OHI' => 0,
                'NR' => $NR,
                'POR' => $POR,
                'POREL' => $POREL,
                'status' => 'On-Progress',

            ]);
            return redirect('/MRP')->with('statusMRP', 'Perhitungan MRP Berhasil!');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MRP  $mRP
     * @return \Illuminate\Http\Response
     */
    public function show(MPS $ID_MPS, MRP $MRP)
    {
        $mrp_BB = DB::table('m_r_p_s')
            ->join('m_p_s', 'm_p_s.ID_MPS', '=', 'm_r_p_s.MPS_ID')
            ->join('boms', 'boms.ID_BOM', '=', 'm_r_p_s.BOM_ID')
            ->join('bahan_bakus', 'bahan_bakus.ID_BahanBaku', '=', 'boms.BahanBaku_ID')
            ->select(
                DB::raw('SUM(m_r_p_s.POREL) as sum_POREL'),
                'm_r_p_s.Produk_ID',
                'm_r_p_s.BOM_ID',
                'm_r_p_s.Tanggal_Pesan',
                'm_r_p_s.Tanggal_Selesai',
                'm_r_p_s.status',
                'boms.BahanBaku_ID',
                'boms.Level_BOM',
                'bahan_bakus.Nama_BahanBaku',
                'bahan_bakus.satuan_BahanBaku')
            ->where('m_r_p_s.MPS_ID', '=', $ID_MPS->ID_MPS)
            ->groupBy('bahan_bakus.Nama_BahanBaku')
            ->get();

        $mrp_etc = MRP::where('MPS_ID', '=', $ID_MPS->ID_MPS)->orderBy("Tanggal_pesan")->get();
        $mps = MPS::with('Produk')->where('ID_MPS', '=', $ID_MPS->ID_MPS)->first();

        return view('Admin.edits.MRP', compact('mps', 'mrp_BB', 'mrp_etc'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MRP  $mRP
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MRP $mRP)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MRP  $mRP
     * @return \Illuminate\Http\Response
     */
    public function destroy(MPS $ID_MPS, MRP $MRP)
    {
        $del = MRP::where("MPS_ID", "=", $ID_MPS->ID_MPS)->get();

        $del->each->delete();
        DB::table('m_p_s')
            ->where('ID_MPS', $ID_MPS->ID_MPS)
            ->update([
                'status' => 'waiting',
            ]);
        return back();
    }
    public function exportFirst(MPS $ID_MPS, MRP $MRP)
    {

        $mrp_BB = DB::table('m_r_p_s')
            ->join('m_p_s', 'm_p_s.ID_MPS', '=', 'm_r_p_s.MPS_ID')
            ->join('boms', 'boms.ID_BOM', '=', 'm_r_p_s.BOM_ID')
            ->join('bahan_bakus', 'bahan_bakus.ID_BahanBaku', '=', 'boms.BahanBaku_ID')
            ->select(
                DB::raw('SUM(m_r_p_s.POREL) as sum_POREL'),
                'm_r_p_s.Produk_ID', 'm_r_p_s.BOM_ID',
                'm_r_p_s.Tanggal_Pesan',
                'm_r_p_s.Tanggal_Selesai',
                'm_r_p_s.status',
                'boms.BahanBaku_ID',
                'boms.Level_BOM',
                'bahan_bakus.Nama_BahanBaku',
                'bahan_bakus.satuan_BahanBaku')
            ->where('m_r_p_s.MPS_ID', '=', $ID_MPS->ID_MPS)
            ->groupBy('bahan_bakus.Nama_BahanBaku')
            ->get();
        $mrp_etc = MRP::where('MPS_ID', '=', $ID_MPS->ID_MPS)->orderBy("Tanggal_pesan")->get();
        $mrpTanggal = MRP::where('MPS_ID', '=', $ID_MPS->ID_MPS)->orderByDesc("Tanggal_Selesai")->first();
        $mps = MPS::with('Produk')->where('ID_MPS', '=', $ID_MPS->ID_MPS)->first();
        $Judul = 'MRP-' . $mps->Produk->Nama_Produk;
        $Tanggal = date('Y-m-d H:i:s');
        $Jumlah = MRP::where('MPS_ID', '=', $ID_MPS->ID_MPS)->orderBy("Tanggal_pesan")
            ->count();
        $pdf = PDF::loadView('Laporan.MRPFirst', compact('mrp_BB', 'mrp_etc', 'mrpTanggal', 'mps', 'Judul', 'Tanggal', 'Jumlah'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream('MRP-Laporan Kebutuhan-' . $mps->Produk->Nama_Produk . '-' . date('ymd') . '.pdf');
    }

    public function exportAll($daterange)
    {
        $date = explode('+', $daterange); //EXPLODE TANGGALNYA UNTUK MEMISAHKAN START & END
        //DEFINISIKAN VARIABLENYA DENGAN FORMAT TIMESTAMPS
        $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
        $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';
        $jenis = 'ALLMRP';
        $Judul = $jenis . '-ALL-LIST';
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

        $pdf = PDF::loadView('Laporan.MRPAll', compact('mrp_BB', 'mrp_etc', 'mpsON', 'Judul', 'Tanggal', 'jenis', 'start', 'end'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream($jenis . '-LIST' . '-' . date('ymd') . '.pdf');
    }
}
