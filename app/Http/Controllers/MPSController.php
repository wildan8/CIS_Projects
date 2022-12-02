<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\StoreMPSRequest;
use App\Http\Requests\UpdateMPSRequest;
use App\Models\MPS;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class MPSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //INISIASI 30 HARI RANGE SAAT INI JIKA HALAMAN PERTAMA KALI DI-LOAD
        //KITA GUNAKAN STARTOFMONTH UNTUK MENGAMBIL TANGGAL 1
        $start = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
        //DAN ENDOFMONTH UNTUK MENGAMBIL TANGGAL TERAKHIR DIBULAN YANG BERLAKU SAAT INI
        $end = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');

        //JIKA USER MELAKUKAN FILTER MANUAL, MAKA PARAMETER DATE AKAN TERISI
        if (request()->date != '') {
            //MAKA FORMATTING TANGGALNYA BERDASARKAN FILTER USER
            $date = explode(' - ', request()->date);
            $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
            $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';
        }

        //BUAT QUERY KE DB MENGGUNAKAN WHEREBETWEEN DARI TANGGAL FILTER
        $mps = MPS::with('Produk')->whereBetween('Tanggal_MPS', [$start, $end])->paginate(10);

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

        $Kode_MPS = Helper::IDGenerator(new MPS, 'ID_MPS', 'Kode_MPS', 2, 'MPS-' . $Find_ID->ID_Produk . $Find_ID->Ukuran_Produk . '-' . date('ymd'));

        MPS::insert([
            'Kode_MPS' => $Kode_MPS,
            'Produk_ID' => $Find_ID->ID_Produk,
            'Ukuran_Produk' => $Find_ID->Ukuran_Produk,
            'Jumlah_MPS' => $request->Jumlah_MPS,
            'Tanggal_MPS' => $request->Tanggal_MPS,
            'status' => 'Waiting',
        ]);
        return redirect('/MPS');
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
    public function edit(MPS $ID_MPS)
    {

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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MPS  $mPS
     * @return \Illuminate\Http\Response
     */
    public function destroy(MPS $ID_MPS)
    {
        $MPSDEL = MPS::find($ID_MPS);
        $MPSDEL->each->delete();
        return redirect('/MPS')->with('statusMPS', 'Hapus Data Produk Berhasil!');
    }
    public function export($daterange)
    {
        $date = explode('+', $daterange); //EXPLODE TANGGALNYA UNTUK MEMISAHKAN START & END
        //DEFINISIKAN VARIABLENYA DENGAN FORMAT TIMESTAMPS
        $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
        $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';
        $Tanggal = date('Y-m-d H:i:s');
        $Judul = 'MPS-' . $Tanggal;
        //KEMUDIAN BUAT QUERY BERDASARKAN RANGE CREATED_AT YANG TELAH DITETAPKAN RANGENYA DARI $START KE $END

        $data = MPS::with('Produk')->whereBetween('Tanggal_MPS', [$start, $end])->paginate(10);
        //LOAD VIEW UNTUK PDFNYA DENGAN MENGIRIMKAN DATA DARI HASIL QUERY
        $pdf = PDF::loadView('Laporan.MPS', compact('data', 'date', 'Judul', 'Tanggal', 'start', 'end'));
        //GENERATE PDF-NYA
        return $pdf->stream();
    }
}
