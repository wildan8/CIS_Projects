<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\StorePenerimaanRequest;
use App\Http\Requests\UpdatePenerimaanRequest;
use App\Models\BahanBaku;
use App\Models\Penerimaan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class PenerimaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $start = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
        $end = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');
        if (request()->date != '') {
            $date = explode(' - ', request()->date);
            $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
            $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';
        }
        $penerimaan = Penerimaan::with('BahanBaku')->whereBetween('Tanggal_LOG', [$start, $end])->orderByDesc('Tanggal_LOG')->paginate(10);
        return view('gudang.tabel.penerimaan', ['penerimaan' => $penerimaan]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $BB = DB::table('bahan_bakus')->get();
        return view('gudang.forms.penerimaan', ['BB' => $BB]);
        // return view('gudang.forms.penerimaan');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePenerimaanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePenerimaanRequest $request)
    {
        $validatedData = $request->validate([
            'BahanBaku_ID' => 'required',
            'Jumlah_LOG' => 'required|integer',
            'Tanggal_LOG' => 'required|date',
            'Status_LOG' => 'required',
        ]);

        if ($request->Status_LOG == "Terima") {
            $Kode_LOG = Helper::IDGenerator(new Penerimaan, 'ID_LOG', 'Kode_LOG', 2, 'LOGTRM-' . $request->BahanBaku_ID . '-' . date('ymd'));
            $BahanBaku = BahanBaku::find($validatedData['BahanBaku_ID']);
            $BahanBaku->Stok_BahanBaku += $validatedData['Jumlah_LOG'];
            $BahanBaku->save();
        } elseif ($request->Status_LOG == "Issuing") {
            $Kode_LOG = Helper::IDGenerator(new Penerimaan, 'ID_LOG', 'Kode_LOG', 2, 'LOGISS-' . $request->BahanBaku_ID . '-' . date('ymd'));
            $BahanBaku = BahanBaku::find($validatedData['BahanBaku_ID']);
            $BahanBaku->Stok_BahanBaku -= $validatedData['Jumlah_LOG'];
            if ($BahanBaku->Stok_BahanBaku < 0) {
                return redirect('/LOG')->with('statusLOGKosong', 'Proses Gagal! Stok sudah Terpakai!');
            } else {
                $BahanBaku->save();
            }
        } else {
            return back();
        }
        Penerimaan::insert([
            'Kode_LOG' => $Kode_LOG,
            'BahanBaku_ID' => $request->BahanBaku_ID,
            'Jumlah_LOG' => $request->Jumlah_LOG,
            'Tanggal_LOG' => $request->Tanggal_LOG,
            'Status_LOG' => $request->Status_LOG,

        ]);
        return redirect('/LOG')->with('statusLOG', 'Input Data LOG Berhasil!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penerimaan  $penerimaan
     * @return \Illuminate\Http\Response
     */
    public function show(Penerimaan $penerimaan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penerimaan  $penerimaan
     * @return \Illuminate\Http\Response
     */
    public function edit(Penerimaan $ID_Penerimaan)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePenerimaanRequest  $request
     * @param  \App\Models\Penerimaan  $penerimaan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePenerimaanRequest $request, Penerimaan $penerimaan)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penerimaan  $penerimaan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penerimaan $ID_LOG)
    {

        $TRMdel = Penerimaan::find($ID_LOG)->first();
        if ($ID_LOG->Status_LOG == "Terima") {
            $BahanBaku = BahanBaku::find($TRMdel->BahanBaku_ID);
            $BahanBaku->Stok_BahanBaku -= $ID_LOG->Jumlah_LOG;
            if ($BahanBaku->Stok_BahanBaku < 0) {
                return redirect('/LOG')->with('statusLOGKosong', 'Gagal Menghapus! Stok sudah Terpakai!');
            } else {
                $BahanBaku->save();
                $TRMdel->delete();
                return redirect('/LOG')->with('hapusLOG', 'Data Penerimaan Berhasil Dihapus!');
            }
        } elseif ($ID_LOG->Status_LOG == "Issuing") {
            $BahanBaku = BahanBaku::find($TRMdel->BahanBaku_ID);
            $BahanBaku->Stok_BahanBaku += $ID_LOG->Jumlah_LOG;
            $BahanBaku->save();
            $TRMdel->delete();
            return redirect('/LOG')->with('hapusLOG', 'Data Penerimaan Berhasil Dihapus!');
        } else {
            return back();
        }
    }
    public function PDF($daterange)
    {
        $date = explode('+', $daterange); //EXPLODE TANGGALNYA UNTUK MEMISAHKAN START & END
        //DEFINISIKAN VARIABLENYA DENGAN FORMAT TIMESTAMPS
        $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
        $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';
        $Judul = 'List Data LOG Bahan Baku';
        $Tanggal = date('Y-m-d H:i:s');
        $Jumlah = Penerimaan::count();
        //KEMUDIAN BUAT QUERY BERDASARKAN RANGE CREATED_AT YANG TELAH DITETAPKAN RANGENYA DARI $START KE $END
        $data = Penerimaan::with('BahanBaku')->whereBetween('Tanggal_LOG', [$start, $end])->orderByDesc('Tanggal_LOG')->get();
        //LOAD VIEW UNTUK PDFNYA DENGAN MENGIRIMKAN DATA DARI HASIL QUERY

        //GENERATE PDF-NYA
        $pdf = PDF::loadView('Laporan.LOG', compact('data', 'Judul', 'Tanggal', 'Jumlah', 'start', 'end'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream();

    }
}
