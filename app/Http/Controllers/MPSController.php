<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMPSRequest;
use App\Http\Requests\UpdateMPSRequest;
use App\Models\BahanBaku;
use App\Models\BOM;
use App\Models\MPS;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;

class MPSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mps = MPS::with('Produk')->get();

        // dd($mps);
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

        $BOM = BOM::where('Kode_BOM', 'like', '%BB' . $Find_ID->ID_Produk . $Find_ID->Ukuran_Produk . '%')
            ->orWhere('Kode_BOM', 'like', '%P' . $Find_ID->ID_Produk . $Find_ID->Ukuran_Produk . '%')
            ->get();
        $arr = [];

        foreach ($BOM as $BOMS) {
            if ($BOMS->BahanBaku_ID == 'null') {
                echo 'kosong';
            } else {
                $BB = BahanBaku::where("ID_BahanBaku", $BOMS->BahanBaku_ID)->get();
                echo $BB, '=>';
            }

            $BOMS->Jumlah_BOM *= $request->Jumlah_MPS;

            // $BB->Stok_BahanBaku -= $BOMS->Jumlah_BOM;
            // if ($BB->Stok_BahanBaku < 0) {
            //     return redirect('/MPS')->with('createMPS', 'Data MPS Gagal Di Buat!');
            // } else {
            //     return redirect('/MPS')->with('statusMPSKosong', 'Gagal Menghapus! Stok sudah Terpakai!');
            //     $tgl = date('Y-m-d', strtotime('+' . $BB->Leadtime_BahanBaku . ' days', strtotime($request->Tanggal_MPS)));
            //     echo $BB->Leadtime_BahanBaku, ',', $request->Tanggal_MPS, '=>', $tgl, ' next ';

            // }

        }

        // $hitung = (integer) $BOM * $request->Jumlah_MPS;

        // $Kode_MPS = Helper::IDGenerator(new MPS, 'ID_MPS', 'Kode_MPS', 2, 'MPS-' . $Find_ID->ID_Produk . $Find_ID->Ukuran_Produk . '-' . date('ymd'));

        // MPS::insert([
        //     'Kode_MPS' => $Kode_MPS,
        //     'Produk_ID' => $Find_ID->ID_Produk,
        //     'Ukuran_Produk' => $Find_ID->Ukuran_Produk,
        //     'Jumlah_MPS' => $request->Jumlah_MPS,
        //     'Tanggal_MPS' => $request->Tanggal_MPS,
        // ]);
        // return redirect('/MPS');
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
    public function edit(MPS $mPS)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MPS  $mPS
     * @return \Illuminate\Http\Response
     */
    public function destroy(MPS $mPS)
    {
        //
    }
}
