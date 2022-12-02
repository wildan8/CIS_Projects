<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\StorePaymentsRequest;
use App\Http\Requests\UpdatePaymentsRequest;
use App\Models\BahanBaku;
use App\Models\MPS;
use App\Models\MRP;
use App\Models\Payments;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class PaymentsController extends Controller
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
        $payment = Payments::with('MRP')->whereBetween('Tanggal_Payment', [$start, $end])->paginate(10);
        // $payment = Payments::with('MRP')->paginate(10);
        //KEMUDIAN LOAD VIEW

        // dd($mrp);

        return view('Payment.Tabel.paymentDone', compact('payment'));
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
     * @param  \App\Http\Requests\StorePaymentsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MRP $ID_MRP)
    {
        $Find_BahanBaku = BahanBaku::where("ID_BahanBaku", $ID_MRP->BOM->BahanBaku_ID)
            ->first();
        $total = $Find_BahanBaku->Harga_Satuan * $ID_MRP->GR;

        $Kode_Payment = Helper::IDGenerator(new Payments, 'ID_Payment', 'Kode_Payment', 2, 'PAY-' . $ID_MRP->ID_MRP . $ID_MRP->MPS_ID . $Find_BahanBaku->ID_BahanBaku . '');

        Payments::insert([
            'MRP_ID' => $ID_MRP->ID_MRP,
            'Kode_Payment' => $Kode_Payment,
            'Harga_Payment' => $total,
            'Tanggal_Payment' => date('y-m-d'),
        ]);
        DB::table('m_r_p_s')
            ->where('ID_MRP', $ID_MRP->ID_MRP)
            ->update([
                'status' => 'Payment-Success',
            ]);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function show(Payments $payments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $payment = DB::table('payments')->get();
        $mpsON = MPS::with('Produk')->where('status', '!=', 'waiting')->get();
        $mrp = MRP::with('MPS', 'Produk', 'BOM')->where('status', '=', 'On-Progress')->orderBy('Tanggal_Selesai')->paginate(10);
        $payment = Payments::with('MRP')->paginate(10);
        // dd($mrp);

        return view('Payment.Tabel.payment', compact('mpsON', 'mrp', 'payment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePaymentsRequest  $request
     * @param  \App\Models\Payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaymentsRequest $request, Payments $payments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payments $ID_Payment)
    {
        $del = Payments::where("ID_Payment", "=", $ID_Payment->ID_Payment)->get();

        $del->each->delete();
        DB::table('m_r_p_s')
            ->where('ID_MRP', $ID_Payment->MRP_ID)
            ->update([
                'status' => 'On-Progress',
            ]);
        return back();
    }

    public function exportPDF($daterange)
    {
        $date = explode('+', $daterange); //EXPLODE TANGGALNYA UNTUK MEMISAHKAN START & END
        //DEFINISIKAN VARIABLENYA DENGAN FORMAT TIMESTAMPS
        $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
        $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';
        $Tanggal = date('Y-m-d H:i:s');
        $Judul = 'PAY-' . $Tanggal;
        //KEMUDIAN BUAT QUERY BERDASARKAN RANGE CREATED_AT YANG TELAH DITETAPKAN RANGENYA DARI $START KE $END
        $payment = Payments::with('MRP')->whereBetween('Tanggal_Payment', [$start, $end])->get();
        //LOAD VIEW UNTUK PDFNYA DENGAN MENGIRIMKAN DATA DARI HASIL QUERY
        $pdf = PDF::loadView('Laporan.Payment', compact('payment', 'date', 'Judul', 'Tanggal', 'start', 'end'));
        //GENERATE PDF-NYA
        return $pdf->stream();
    }
}
