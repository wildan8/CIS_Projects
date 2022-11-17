<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProdukRequest;
use App\Http\Requests\UpdateProdukRequest;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use PDF;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produk = DB::table('produks')->get();
        return view('produksi.tabel.produk', ['produk' => $produk]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('produksi.forms.produk');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProdukRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProdukRequest $request)
    {
        $validatedData = $request->validate([
            'Nama_Produk' => 'required|max:255',
            'Ukuran_Produk' => 'required|max:5',
            'Leadtime_Assembly' => 'required|integer',
        ]);
        Produk::insert([
            'Nama_Produk' => $request->Nama_Produk,
            'Ukuran_Produk' => $request->Ukuran_Produk,
            'Leadtime_Assembly' => $request->Leadtime_Assembly,
            'Level_BOM' => 0,
        ]);

        return redirect('/produk')->with('statusProduk', 'Input Data Produk Berhasil!');
        // DB::table('produks')-> insert([
        //     'Nama_Produk' => $request -> Nama_Produk,
        //     'Ukuran_Produk' => $request -> Ukuran_Produk,
        //     'Jumlah_Produk' => $request -> Jumlah_Produk,
        // ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function show(Produk $produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function edit(Produk $ID_Produk)
    {
        $produk = collect(Produk::find($ID_Produk))->first();
        // dd($produk);
        return view('produksi.edits.produk', compact('produk'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProdukRequest  $request
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProdukRequest $request, Produk $ID_Produk)
    {
        $validatedData = $request->validate([
            'Nama_Produk' => 'required',
            'Ukuran_Produk' => 'required',
            'Leadtime_Assembly' => 'required|integer',
        ]);

        Produk::where('ID_Produk', $request->ID_Produk)
            ->update($validatedData);
        return redirect('/produk')->with('updateProduk', 'Data Produk Berhasil Diupdate!');
        // DB::table('produks')
        // ->where('ID_Produk', $request -> ID_Produk)
        // ->update([
        //     'Nama_Produk' => $request -> Nama_Produk,
        //     'Ukuran_Produk' => $request -> Ukuran_Produk,
        //     'Jumlah_Produk' => $request -> Jumlah_Produk

        // ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produk $ID_Produk)
    {
        $produkDEL = Produk::find($ID_Produk);
        $produkDEL->each->delete();
        return redirect('/produk')->with('statusProduk', 'Hapus Data Produk Berhasil!');
    }
    public function PDF()
    {
        $data = Produk::all();
        // dd($Produk);
        $Judul = 'List Data Produk';
        $Tanggal = date('Y-m-d H:i:s');
        $Jumlah = Produk::count();
        $pdf = PDF::loadView('Laporan.Produk', compact('data', 'Judul', 'Tanggal', 'Jumlah'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream('LIST DATA Produk-' . date('ymd') . '.pdf');
    }
}
