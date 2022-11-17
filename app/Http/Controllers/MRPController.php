<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\BahanBaku;
use App\Models\BOM;
use App\Models\MPS;
use App\Models\MRP;
use App\Models\Produk;
use Illuminate\Http\Request;

class mrpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mps = MPS::with('Produk')->get();

        return view('Admin.tabel.MRP', compact('mps'));
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
            ->get();

        $Kode_MRP = Helper::IDGenerator(new MRP, 'ID_MRP', 'Kode_MRP', 2, 'MRP-' . $Find_Produk->ID_Produk . $Find_Produk->Ukuran_Produk . $ID_MPS->ID_MPS . '-');

        foreach ($BOM as $Bo) {

            if ($Bo->Tipe_BOM == "Parts") {
                $NR = $POR = $POREL = $GR = $Bo->Jumlah_BOM;
                $OHI = 0;
                echo '{{ Part => NR ', $NR, ', POR ', $POR, ', POREL ', $POREL, ', GR ', $GR, ', Tanggal Pesan: -- , ', 'Tanggal Jadi:-- }}</br> ';

                // echo $Bo->Nama_Part, ',', $GR, ',', $OHI, ',';
            } elseif ($Bo->Tipe_BOM == "BahanBaku") {
                $BB = BahanBaku::where('ID_BahanBaku', '=', $Bo->BahanBaku_ID)->first();
                $NR = $POR = $POREL = $GR = $Bo->Jumlah_BOM;
                $OHI = $BB->Stok_BahanBaku;
                $date = date('Y-m-d', strtotime('+' . $BB->Leadtime_BahanBaku . ' days', strtotime($ID_MPS->Tanggal_MPS)));
                echo ' {{ </br> BAHANBAKU => NR ', $NR, ', POR ', $POR, ', POREL ', $POREL, ', GR ', $GR, '</br> -> Leadtime: ', $BB->Leadtime_BahanBaku, ' , </br> ->Tanggal Pesan:-- , ', $ID_MPS->Tanggal_MPS, '</br> -> Tanggal Jadi:-- ', $date, '</br> }}</br>';
                // echo $BB->ID_BahanBaku, ',', $GR, ',', $OHI, ',';
            }
            // MRP::insert([
            //     'Kode_MRP' => $Kode_MRP,
            //     'MPS_ID' => $ID_MPS->ID_MPS,
            //     'Produk_ID' => $Find_Produk->ID_Produk,
            //     'BOM_ID' => $B->ID_BOM,
            //     'Tanggal_Selesai' => 'Gak Tau',
            //     'GR' => $GR,
            //     'SR',
            //     'OHI' => $OHI,
            //     'NR' => $NR,
            //     'POR'=> $POR,
            //     'POREL'=> $POREL,
            //     'status',
            // ]);

        }

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
