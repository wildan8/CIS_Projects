<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Supplier;
use PDF;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplier = Supplier::all();
        return view('gudang.tabel.supplier', compact('supplier'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('gudang.forms.supplier');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSupplierRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSupplierRequest $request)
    {
        $validatedData = $request->validate([
            'Nama_Supplier' => 'required|max:255|unique:suppliers,Nama_Supplier',
            'Pemilik_Supplier' => 'required|regex: /^[a-zA-Z .]*$/|',
            'Alamat_Supplier' => 'required|max:255',
            'Telp_Supplier' => 'required|max:12',
        ]);

        $Kode_Supplier = Helper::IDGenerator(new Supplier, 'ID_Supplier', 'Kode_Supplier', 2, 'SUP');
        Supplier::insert([
            'Kode_Supplier' => $Kode_Supplier,
            'Nama_Supplier' => $request->Nama_Supplier,
            'Pemilik_Supplier' => $request->Pemilik_Supplier,
            'Alamat_Supplier' => $request->Alamat_Supplier,
            'Telp_Supplier' => $request->Telp_Supplier,
        ]);

        return redirect('/Supplier')->with('statusSupplier', 'Input Data Supplier Berhasil!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        return view('supplier', [
            "supplier" => $supplier,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit($ID_Supplier)
    {

        $supplier = Supplier::find($ID_Supplier);
        return view('gudang.edits.supplier', compact('supplier'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSupplierRequest  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        $validatedData = $request->validate([
            'Nama_Supplier' => 'required|max:255',
            'Pemilik_Supplier' => 'required|regex: /^[a-zA-Z .]*$/|',
            'Alamat_Supplier' => 'required|max:255',
            'Telp_Supplier' => 'required|max:12',
        ]);

        Supplier::where('ID_Supplier', $request->ID_Supplier)
            ->update($validatedData);
        return redirect('/Supplier')->with('updateSupplier', 'Data Supplier Berhasil Diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $ID_Supplier)
    {
        $suppDEL = Supplier::find($ID_Supplier);
        $suppDEL->each->delete();
        return redirect('/Supplier')->with('hapusSupplier', 'Data Supplier Berhasil Dihapus!');
    }
    public function PDF()
    {
        $data = Supplier::all();
        // dd($Supplier);
        $Judul = 'List Data Supplier';
        $Tanggal = date('Y-m-d H:i:s');
        $Jumlah = Supplier::count();
        $pdf = PDF::loadView('Laporan.Supplier', compact('data', 'Judul', 'Tanggal', 'Jumlah'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream('LIST DATA SUPPLIER-' . date('ymd') . '.pdf');
    }

}
