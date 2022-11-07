<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBahanBakuRequest;
use App\Http\Requests\UpdateBahanBakuRequest;
use App\Models\BahanBaku;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class BahanBakuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $bahanbaku = BahanBaku::with('Supplier')->get();

        return view('gudang.tabel.bahanbaku', compact('bahanbaku'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sup = DB::table('suppliers')->get();
        return view('gudang.forms.bahanbaku', ['sup' => $sup]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBahanBakuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBahanBakuRequest $request)
    {
        $validatedData = $request->validate([
            'Nama_BahanBaku' => 'required',
            'Stok_BahanBaku' => 'required|integer',
            'Harga_Satuan' => 'required|integer',
            'Supplier_ID' => 'required',
        ]);

        BahanBaku::create($validatedData);
        return redirect('/Bahanbaku')->with('statusBahanBaku', 'Input Data Bahanbaku Berhasil!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BahanBaku  $bahanBaku
     * @return \Illuminate\Http\Response
     */
    public function show(BahanBaku $bahanBaku)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BahanBaku  $bahanBaku
     * @return \Illuminate\Http\Response
     */
    public function test(BahanBaku $ID_BahanBaku)
    {
        $BB = collect(BahanBaku::find($ID_BahanBaku))->first();
        $sup = Supplier::all();
        return view('gudang.edits.bahanbaku', compact('BB', 'sup'));
        // dd($BB);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBahanBakuRequest  $request
     * @param  \App\Models\BahanBaku  $bahanBaku
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBahanBakuRequest $request, BahanBaku $bahanBaku)
    {
        $BB = BahanBaku::with('Supplier')->get();

        DB::table('bahan_bakus')
            ->where('ID_BahanBaku', $request->IDBB)
            ->update([
                'Supplier_ID' => $request->NamaSUP,
                'Nama_BahanBaku' => $request->NamaBB,
                'Stok_BahanBaku' => $request->StokBB,
                'Harga_Satuan' => $request->HargaSatuanBB,
                'Supplier_ID' => $request->SupplierID,
            ]);
        return redirect('/Bahanbaku');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BahanBaku  $bahanBaku
     * @return \Illuminate\Http\Response
     */
    public function destroy(BahanBaku $ID_BahanBaku)
    {
        $BBdel = BahanBaku::find($ID_BahanBaku);
        // dd($ID_BahanBaku);
        $BBdel->each->delete();
        return redirect('/Bahanbaku')->with('status', 'YAY! Data Berhasil Dihapus!');
    }
}
