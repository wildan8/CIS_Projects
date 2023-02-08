<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\StoreBOMRequest;
use App\Http\Requests\UpdateBOMRequest;
use App\Models\BahanBaku;
use App\Models\BOM;
use App\Models\Produk;
use PDF;

class BOMController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Produk = Produk::paginate(10);
        return view('produksi.tabel.BOM', compact('Produk'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $PROD = Produk::all();
        $BB = BahanBaku::all();
        return view('produksi.forms.BOM', compact('PROD', 'BB'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBOMRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBOMRequest $request)
    {
        $Parts = BOM::where('ID_BOM', '=', $request->Select_Parts)
            ->first();
        $request->validate([
            'Produk_ID' => 'required',
            'Ukuran_Produk' => 'required',
            'Tipe_BOM' => 'required',
            'Jumlah_BOM' => 'required|integer',
        ]);

        if ($request->Tipe_BOM == 'Parts') {
            $Kode_BOM = Helper::IDGenerator(new Bom, 'ID_BOM', 'Kode_BOM', 2, 'BOM-P' . $request->Produk_ID . $request->Ukuran_Produk);
            $Jumlah_BOM = $request->Jumlah_BOM;
            $Level = 1;
            $Nama_Part = $request->Nama_Part;
        } elseif ($request->Tipe_BOM == 'BahanBaku') {
            $Kode_BOM = Helper::IDGenerator(new Bom, 'ID_BOM', 'Kode_BOM', 2, 'BOM-BB' . $request->Produk_ID . $request->Ukuran_Produk . $request->BahanBaku_ID);
            $Jumlah_BOM = $request->Jumlah_BOM * $Parts->Jumlah_BOM;
            $Level = 2;
            $Nama_Part = $Parts->Nama_Part;
        } else {
            $Kode_BOM = 'none';
        }

        BOM::insert([

            'Kode_BOM' => $Kode_BOM,
            'Produk_ID' => $request->Produk_ID,
            'BahanBaku_ID' => $request->BahanBaku_ID,
            'Ukuran_Produk' => $request->Ukuran_Produk,
            'Tipe_BOM' => $request->Tipe_BOM,
            'Level_BOM' => $Level,
            'Nama_Part' => $Nama_Part,
            'Leadtime_BOM' => $request->Leadtime_BOM,
            'Jumlah_BOM' => $Jumlah_BOM,
        ]);
        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BOM  $bOM
     * @return \Illuminate\Http\Response
     */
    public function edit(BOM $ID_BOM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BOM  $bOM
     * @return \Illuminate\Http\Response
     */
    public function show(Produk $ID_Produk)
    {
        $Produk = $ID_Produk;

        $BB = BahanBaku::all();
        $P = BOM::where('Kode_BOM', 'like', '%P' . $ID_Produk->ID_Produk . $ID_Produk->Ukuran_Produk . '%')
            ->where('Tipe_BOM', '=', 'Parts')
            ->get();
        $Parts = BOM::where('Kode_BOM', 'like', '%P' . $ID_Produk->ID_Produk . $ID_Produk->Ukuran_Produk . '%')
            ->where('Tipe_BOM', '=', 'Parts')
            ->get();
        $BOM = BOM::with('BahanBaku')
            ->where('Kode_BOM', 'like', '%BB' . $ID_Produk->ID_Produk . $ID_Produk->Ukuran_Produk . '%')
            ->where('Tipe_BOM', '=', 'BahanBaku')
            ->get();
        // dd($BOM);
        return view('Produksi.edits.BOM', compact('Produk', 'BB', 'BOM', 'P', 'Parts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBOMRequest  $request
     * @param  \App\Models\BOM  $bOM
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBOMRequest $request, BOM $bOM)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BOM  $bOM
     * @return \Illuminate\Http\Response
     */
    public function destroyBB(BOM $ID_BOM)
    {
        $BOMDEL = BOM::find($ID_BOM);
        $BOMDEL->each->delete();
        return back()->with('hapusBOM', 'Hapus Data BOM Berhasil!');
    }
    public function destroyParts(BOM $ID_BOM)
    {
        $BOMDEL = BOM::find($ID_BOM);
        $BOMDEL->each->delete();
        return back()->with('hapusBOM', 'Hapus Data BOM Berhasil!');
    }
    public function PDF(Produk $ID_Produk)
    {
        $Produk = $ID_Produk;
        $BB = BahanBaku::all();
        $dataBB = BOM::with('BahanBaku')
            ->where('Kode_BOM', 'like', '%' . $ID_Produk->ID_Produk . '%' . $ID_Produk->Ukuran_Produk . '%')
            ->where('Tipe_BOM', '=', 'BahanBaku')
            ->get();
        $dataParts = BOM::with('BahanBaku')
            ->where('Kode_BOM', 'like', '%' . $ID_Produk->ID_Produk . '%' . $ID_Produk->Ukuran_Produk . '%')
            ->where('Tipe_BOM', '=', 'Parts')
            ->get();

        $Judul = 'List Data BOM';
        $Tanggal = date('Y-m-d H:i:s');
        $Jumlah = BOM::with('BahanBaku')
            ->where('Kode_BOM', 'like', '%' . $ID_Produk->ID_Produk . '%' . $ID_Produk->Ukuran_Produk . '%')
            ->count();
        $pdf = PDF::loadView('Laporan.BOM', compact('dataParts', 'dataBB', 'Judul', 'Tanggal', 'Jumlah', 'Produk'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream('LIST DATA BOM-' . $ID_Produk->Nama_Produk . '-' . date('ymd') . '.pdf');
    }
}
