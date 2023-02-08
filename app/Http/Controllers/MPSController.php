<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\StoreMPSRequest;
use App\Http\Requests\UpdateMPSRequest;
use App\Models\BahanBaku;
use App\Models\BOM;
use App\Models\MPS;
use App\Models\MRP;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class MPSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $start = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
        $end = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');
        if (request()->date != '') {
            $date = explode(' - ', request()->date);
            $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
            $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';
        }
        $mps = DB::table('m_r_p_s')
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
        return view('Admin.tabel.MPS', compact('mps'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $PR = DB::table('produks')->select('Nama_Produk')->distinct('Nama_Produk')->get();
        return view('Admin.forms.MPS', compact('PR'));
    }

    public function fetchProduk(StoreMPSRequest $request)
    {
        $data['produks'] = Produk::where("Nama_Produk", $request->Produk_ID)->get("Ukuran_Produk");
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMPSRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMPSRequest $request)
    {
        $validatedData = $request->validate([
            'Produk_ID' => 'required',
            'Ukuran_Produk' => 'required',
            'Jumlah_MPS' => 'required|integer',
            'Tanggal_MPS' => 'required|date',
        ]);
        $Find_ID = produk::where("Nama_Produk", $request->Produk_ID)
            ->where("Ukuran_Produk", $request->Ukuran_Produk)
            ->first();
        $Kode_MPS = Helper::IDGenerator(new MPS, 'ID_MPS', 'Kode_MPS', 2, 'MPS-' . $Find_ID->ID_Produk . $Find_ID->Ukuran_Produk . '-' . date('ymd'));
        MPS::insert([
            'Kode_MPS' => $Kode_MPS,
            'Produk_ID' => $Find_ID->ID_Produk,
            'Ukuran_Produk' => $Find_ID->Ukuran_Produk,
            'Jumlah_MPS' => $request->Jumlah_MPS,
            'Tanggal_MPS' => $request->Tanggal_MPS,
            'status' => 'Waiting',
        ]);
        $mpsID = DB::getPdo()->lastInsertId();
        $mpsInsert = MPS::where('ID_MPS', '=', $mpsID)->first();
        $BOM = BOM::where('Kode_BOM', 'like', '%BB' . $Find_ID->ID_Produk . $Find_ID->Ukuran_Produk . '%')
            ->orWhere('Kode_BOM', 'like', '%P' . $Find_ID->ID_Produk . $Find_ID->Ukuran_Produk . '%')
            ->orderBy("Tipe_BOM")->get();
        // echo '<br> test' . $BOM;
        $Kode_MRP = Helper::IDGenerator(new MRP, 'ID_MRP', 'Kode_MRP', 2, 'MRP-' . $Find_ID->ID_Produk . $Find_ID->Ukuran_Produk . $mpsInsert->ID_MPS . '-');

        foreach ($BOM as $Bo) {
            if ($Bo->Tipe_BOM == "BahanBaku") {
                $BB = BahanBaku::where('ID_BahanBaku', '=', $Bo->BahanBaku_ID)->first();
                $NR = $POR = $POREL = $GR = $Bo->Jumlah_BOM * $mpsInsert->Jumlah_MPS;
                $OHI = 0;
                $dateStart = $mpsInsert->Tanggal_MPS;
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
                $dateDone = date('Y-m-d', strtotime('+' . $count . ' days', strtotime($mpsInsert->Tanggal_MPS)));

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
                    $NR = $POR = $POREL = $GR = $Bo->Jumlah_BOM * $mpsInsert->Jumlah_MPS;

                    $OHI = 0;
                    $dateStart = $late->Tanggal_Selesai;
                    $dateDone = date('Y-m-d', strtotime('+' . $count . ' days', strtotime($late->Tanggal_Selesai)));

                }
            } else {
                return redirect('/MRP')->with('nullMRP', 'Perhitungan MRP Gagal! isi BOM terlebih dahulu!');
            }
            MRP::insert([
                'Kode_MRP' => $Kode_MRP,
                'MPS_ID' => $mpsInsert->ID_MPS,
                'Produk_ID' => $Find_ID->ID_Produk,
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
        $itung = $mpsInsert->Jumlah_MPS;
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

        $count = $Find_ID->Leadtime_Assembly * $count;
        $NR = $POR = $POREL = $GR = $mpsInsert->Jumlah_MPS;
        $late = MRP::where('Kode_MRP', '=', $Kode_MRP)->orderByDesc('Tanggal_Selesai')->first();
        if ($late == null) {
            return redirect('/MRP')->with('nullMRP', 'Perhitungan MRP Gagal! isi BOM terlebih dahulu!');
        } else {
            // dd($late);
            $date = date('Y-m-d', strtotime('+' . $count . ' days', strtotime($late->Tanggal_Selesai)));
            DB::table('m_p_s')
                ->where('ID_MPS', $mpsInsert->ID_MPS)
                ->update([
                    'status' => 'On-Progress',
                ]);
            MRP::insert([
                'Kode_MRP' => $Kode_MRP,
                'MPS_ID' => $mpsInsert->ID_MPS,
                'Produk_ID' => $Find_ID->ID_Produk,
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
            return redirect('/MPS')->with('statusMPS', 'Input data Berhasil!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MPS  $mPS
     * @return \Illuminate\Http\Response
     */
    public function show(MPS $mPS)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MPS  $mPS
     * @return \Illuminate\Http\Response
     */
    public function edit(MPS $ID_MPS)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMPSRequest  $request
     * @param  \App\Models\MPS  $mPS
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMPSRequest $request, MPS $mPS)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MPS  $mPS
     * @return \Illuminate\Http\Response
     */
    public function destroy(MPS $ID_MPS)
    {
        $del = MRP::where("MPS_ID", "=", $ID_MPS->ID_MPS)->get();

        $del->each->delete();

        $MPSDEL = MPS::find($ID_MPS);
        $MPSDEL->each->delete();
        return redirect('/MPS')->with('statusMPS', 'Hapus Data Produk Berhasil!');
    }
    public function export($daterange)
    {
        $date = explode('+', $daterange); //EXPLODE TANGGALNYA UNTUK MEMISAHKAN START & END
        //DEFINISIKAN VARIABLENYA DENGAN FORMAT TIMESTAMPS
        $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
        $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';
        $Tanggal = date('Y-m-d H:i:s');
        $Judul = 'MPS-' . $Tanggal;
        //KEMUDIAN BUAT QUERY BERDASARKAN RANGE CREATED_AT YANG TELAH DITETAPKAN RANGENYA DARI $START KE $END

        $data = MPS::with('Produk')->whereBetween('Tanggal_MPS', [$start, $end])->paginate(10);
        //LOAD VIEW UNTUK PDFNYA DENGAN MENGIRIMKAN DATA DARI HASIL QUERY
        $pdf = PDF::loadView('Laporan.MPS', compact('data', 'date', 'Judul', 'Tanggal', 'start', 'end'));
        //GENERATE PDF-NYA
        return $pdf->stream();
    }
}
