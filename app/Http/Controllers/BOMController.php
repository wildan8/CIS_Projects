<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\StoreBOMRequest;
use App\Http\Requests\UpdateBOMRequest;
use App\Models\BahanBaku;
use App\Models\BOM;
use App\Models\Produk;

class BOMController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Produk = Produk::all();
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
        $request->validate([
            'Produk_ID' => 'required',
            'BahanBaku_ID' => 'required',
            'Ukuran_Produk' => 'required',
            'Jumlah_BOM' => 'required',
        ]);

        $Kode_BOM = Helper::IDGenerator(new Bom, 'ID_BOM', 'Kode_BOM', 2, $request->Produk_ID . $request->BahanBaku_ID . $request->Ukuran_Produk);

        BOM::insert([
            'Kode_BOM' => $Kode_BOM,
            'Produk_ID' => $request->Produk_ID,
            'BahanBaku_ID' => $request->BahanBaku_ID,
            'Ukuran_Produk' => $request->Ukuran_Produk,
            'Jumlah_BOM' => $request->Jumlah_BOM,
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
        $Produk = collect(Produk::find($ID_Produk))->first();
        $BB = BahanBaku::all();
        $BOM = BOM::with('BahanBaku')
            ->where('Kode_BOM', 'like', $ID_Produk->ID_Produk . '%' . $ID_Produk->Ukuran_Produk . '%')
            ->get();
        return view('Produksi.edits.BOM', compact('Produk', 'BB', 'BOM'));
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
    public function destroy(BOM $ID_BOM)
    {
        $BOMDEL = BOM::find($ID_BOM);
        $BOMDEL->each->delete();
        return back()->with('hapusBOM', 'Hapus Data BOM Berhasil!');
    }
}
