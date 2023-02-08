<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIssuingRequest;
use App\Http\Requests\UpdateIssuingRequest;
use App\Models\BahanBaku;
use App\Models\Issuing;
use Illuminate\Support\Facades\DB;

class IssuingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $issuing = Issuing::with('BahanBaku')->get();
        return view('gudang.tabel.Issuing', compact('issuing'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $BB = DB::table('bahan_bakus')->get();
        return view('gudang.forms.issuing', ['BB' => $BB]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreIssuingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIssuingRequest $request)
    {
        $validatedData = $request->validate([
            'BahanBaku_ID' => 'required',
            'Jumlah_Issuing' => 'required|integer',
            'Tanggal_Issuing' => 'required|date',
        ]);
        $BahanBaku = BahanBaku::find($validatedData['BahanBaku_ID']);

        $BahanBaku->Stok_BahanBaku -= $validatedData['Jumlah_Issuing'];

        if ($BahanBaku->Stok_BahanBaku < 0) {
            return redirect('/Issuing')->with('statusIssuingKosong', 'Permintaan Melebihi Stok yang Tersedia');
        } else {
            $BahanBaku->save();
            Issuing::create($validatedData);
            return redirect('/Issuing')->with('statusIssuing', 'Input Data Issuing Berhasil!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Issuing  $issuing
     * @return \Illuminate\Http\Response
     */
    public function show(Issuing $issuing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Issuing  $issuing
     * @return \Illuminate\Http\Response
     */
    public function edit(Issuing $ID_Issuing)
    {
        $ISS = collect(Issuing::find($ID_Issuing))->first();
        $BB = BahanBaku::all();
        // dd($ISS);
        return view('gudang.edits.issuing', compact('ISS', 'BB'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateIssuingRequest  $request
     * @param  \App\Models\Issuing  $issuing
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIssuingRequest $request, Issuing $issuing)
    {
        $BB = Issuing::with('BahanBaku')->get();

        DB::table('issuings')
            ->where('ID_Issuing', $request->IDISS)
            ->update([
                'BahanBaku_ID' => $request->BahanBaku_ID,
                'Jumlah_Issuing' => $request->jumlah,
                'Tanggal_Issuing' => $request->tanggal,

            ]);
        return redirect('/Issuing');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Issuing  $issuing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Issuing $ID_Issuing)
    {

        $ISSdel = Issuing::find($ID_Issuing)->first();
        $BahanBaku = BahanBaku::find($ISSdel->BahanBaku_ID);

        $BahanBaku->Stok_BahanBaku += $ISSdel->Jumlah_Issuing;
        $BahanBaku->save();
        // dd($ID_BahanBaku);
        $ISSdel->delete();
        return redirect('/Issuing')->with('hapusIssuing', 'Data Issuing Berhasil Dihapus!');
    }
}
