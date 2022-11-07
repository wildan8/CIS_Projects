<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReturnProdukRequest;
use App\Http\Requests\UpdateReturnProdukRequest;
use App\Models\ReturnProduk;
use Illuminate\Support\Facades\DB;

class ReturnProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $return = DB::table('return_produks')->get();
        return view('gudang.tabel.return', ['return' => $return]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReturnProdukRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReturnProdukRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReturnProduk  $returnProduk
     * @return \Illuminate\Http\Response
     */
    public function show(ReturnProduk $returnProduk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReturnProduk  $returnProduk
     * @return \Illuminate\Http\Response
     */
    public function edit(ReturnProduk $returnProduk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReturnProdukRequest  $request
     * @param  \App\Models\ReturnProduk  $returnProduk
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReturnProdukRequest $request, ReturnProduk $returnProduk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReturnProduk  $returnProduk
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReturnProduk $returnProduk)
    {
        //
    }
}
