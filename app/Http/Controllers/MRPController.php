<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\BahanBaku;
use App\Models\BOM;
use App\Models\MPS;
use App\Models\MRP;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class mrpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $mps = MPS::with('Produk')->where('status', '=', 'waiting')->get();
        $mrp = MRP::with('MPS', 'Produk', 'BOM')->orderBy('Tanggal_Selesai')->get();

        return view('Admin.tabel.MRP', compact('mps', 'mrp'));
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
        $BOM = BOM::where('Kode_BOM', 'like', '%BB' . $Find_Produk->ID_Produk . $Find_Produk->Ukuran_Produk . '%')
            ->orWhere('Kode_BOM', 'like', '%P' . $Find_Produk->ID_Produk . $Find_Produk->Ukuran_Produk . '%')
            ->orderBy("Tipe_BOM")->get();

        $Kode_MRP = Helper::IDGenerator(new MRP, 'ID_MRP', 'Kode_MRP', 2, 'MRP-' . $Find_Produk->ID_Produk . $Find_Produk->Ukuran_Produk . $ID_MPS->ID_MPS . '-');

        foreach ($BOM as $Bo) {

            if ($Bo->Tipe_BOM == "BahanBaku") {
                echo ('BahanBaku, ');

                $BB = BahanBaku::where('ID_BahanBaku', '=', $Bo->BahanBaku_ID)->first();
                $NR = $POR = $POREL = $GR = $Bo->Jumlah_BOM * $ID_MPS->Jumlah_MPS;
                $OHI = $BB->Stok_BahanBaku;
                $dateStart = $ID_MPS->Tanggal_MPS;
                $dateDone = date('Y-m-d', strtotime('+' . $BB->Leadtime_BahanBaku . ' days', strtotime($ID_MPS->Tanggal_MPS)));
                echo ' {{ </br></br> BAHANBAKU(', $BB->Nama_BahanBaku, ',', $Bo->Nama_Part, ',)</br>=> NR ', $NR, ', POR ', $POR, ', POREL ', $POREL, ', GR ', $GR, '</br> -> Leadtime: ', $BB->Leadtime_BahanBaku, ' , </br> ->Tanggal Pesan:-- , ', $ID_MPS->Tanggal_MPS, '</br> -> Tanggal Jadi:-- ', $dateDone, '</br> }}</br>';

            } elseif ($Bo->Tipe_BOM == "Parts") {
                $cek = BOM::where('Nama_Part', '=', $Bo->Nama_Part)
                    ->where('Tipe_BOM', '=', 'BahanBaku')->count();
                $BB = BOM::where('Nama_Part', '=', $Bo->Nama_Part)
                    ->where('Tipe_BOM', '=', 'BahanBaku')->first();
                $late = MRP::where('Kode_MRP', '=', $Kode_MRP)->orderByDesc('Tanggal_Pesan')->first();

                if ($cek == 0) {
                    echo '</br> salaah, </br> ';
                } else {

                    $Bu = BahanBaku::where('ID_BahanBaku', '=', $BB->BahanBaku_ID)->first();
                    $NR = $POR = $POREL = $GR = $Bo->Jumlah_BOM * $ID_MPS->Jumlah_MPS;
                    // dd($Bu->Leadtime_BahanBaku);
                    $OHI = 0;
                    $dateStart = $late->Tanggal_Selesai;
                    $dateDone = date('Y-m-d', strtotime('+' . $Bo->Leadtime_BOM . ' days', strtotime($late->Tanggal_Selesai)));
                    echo ' {{</br> </br> Part (', $Bo->Nama_Part, ')</br>=> NR ', $NR, ', POR ', $POR, ', POREL ', $POREL, ', GR ', $GR, '</br> -> Leadtime: ', $Bo->Leadtime_BOM, ' , </br> ->Tanggal Pesan:-- , ', $dateStart, '</br> -> Tanggal Jadi:-- ', $dateDone, '</br> }}</br>';
                }

            }
            // dd("y");
            MRP::insert([
                'Kode_MRP' => $Kode_MRP,
                'MPS_ID' => $ID_MPS->ID_MPS,
                'Produk_ID' => $Find_Produk->ID_Produk,
                'BOM_ID' => $Bo->ID_BOM,
                'Tanggal_Pesan' => $dateStart,
                'Tanggal_Selesai' => $dateDone,
                'GR' => $GR,
                'SR' => 0,
                'OHI' => $OHI,
                'NR' => $NR,
                'POR' => $POR,
                'POREL' => $POREL,
            ]);

        }
        // MRP Produk
        $late = MRP::where('Kode_MRP', '=', $Kode_MRP)->orderByDesc('Tanggal_Selesai')->first();
        $date = date('Y-m-d', strtotime('+' . $Find_Produk->Leadtime_Assembly . ' days', strtotime($late->Tanggal_Selesai)));

        // $date = asd;
        MRP::insert([
            'Kode_MRP' => $Kode_MRP,
            'MPS_ID' => $ID_MPS->ID_MPS,
            'Produk_ID' => $Find_Produk->ID_Produk,
            'Tanggal_Pesan' => $dateStart,
            'Tanggal_Selesai' => $date,
            'GR' => $GR,
            'SR' => 0,
            'OHI' => $OHI,
            'NR' => $NR,
            'POR' => $POR,
            'POREL' => $POREL,

        ]);
        DB::table('m_p_s')
            ->where('ID_MPS', $ID_MPS->ID_MPS)
            ->update([
                'status' => 'On-Progress',
            ]);
        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MRP  $mRP
     * @return \Illuminate\Http\Response
     */
    public function show(MRP $mRP)
    {
        //
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
    public function destroy(MRP $mRP)
    {
        //
    }
}
