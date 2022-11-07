<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMPSRequest;
use App\Http\Requests\UpdateMPSRequest;
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
        $MPS = DB::table('MPS')->get();
        return view('Admin.tabel.MPS', ['MPS' => $MPS]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $PR = Produk::all();
        return view('Admin.forms.MPS', compact('PR'));
    }
    public function fetch(Request $request)
    {

        $Ukuran_Produk = collect(Produk::find($request->Produk_ID))
            ->select('Ukuran_Produk')
            ->get();

        return (response(['ukuranProduk' => $Ukuran_Produk]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMPSRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMPSRequest $request)
    {
        //
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
