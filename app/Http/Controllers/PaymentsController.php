<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\StorePaymentsRequest;
use App\Http\Requests\UpdatePaymentsRequest;
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
        $start = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
        $end = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');
        if (request()->date != '') {
            $date = explode(' - ', request()->date);
            $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
            $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';
        }
        $payment = Payments::with('MRP')->whereBetween('Tanggal_Payment', [$start, $end])->paginate(10);
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
        $mrp = DB::table('m_r_p_s')
            ->join('m_p_s', 'm_p_s.ID_MPS', '=', 'm_r_p_s.MPS_ID')
            ->join('boms', 'boms.ID_BOM', '=', 'm_r_p_s.BOM_ID')
            ->join('bahan_bakus', 'bahan_bakus.ID_BahanBaku', '=', 'boms.BahanBaku_ID')
            ->select(DB::raw('SUM(m_r_p_s.POREL) as sum_POREL'),
                'm_p_s.ID_MPS',
                'm_r_p_s.Kode_MRP',
                'm_r_p_s.ID_MRP',
                'm_r_p_s.MPS_ID',
                'm_r_p_s.Produk_ID',
                'm_r_p_s.BOM_ID',
                'm_r_p_s.Tanggal_Pesan',
                'm_r_p_s.Tanggal_Selesai',
                'm_r_p_s.status',
                'boms.BahanBaku_ID',
                'boms.Level_BOM',
                'bahan_bakus.ID_BahanBaku',
                'bahan_bakus.Nama_BahanBaku',
                'bahan_bakus.Satuan_BahanBaku',
                'bahan_bakus.Harga_Satuan'
            )
            ->where("ID_BahanBaku", $ID_MRP->BOM->BahanBaku_ID)
            ->where('m_r_p_s.MPS_ID', '=', $ID_MRP->MPS_ID)
            ->groupBy('bahan_bakus.Nama_BahanBaku')
            ->groupBy('m_p_s.ID_MPS')
            ->orderBy('m_r_p_s.Tanggal_Selesai')
            ->first();
        $total = $mrp->sum_POREL * $mrp->Harga_Satuan;
        $Kode_Payment = Helper::IDGenerator(new Payments, 'ID_Payment', 'Kode_Payment', 2, 'PAY-' . $ID_MRP->ID_MRP . $ID_MRP->MPS_ID . $mrp->ID_BahanBaku . '');

        Payments::insert([
            'MRP_ID' => $ID_MRP->ID_MRP,
            'Kode_Payment' => $Kode_Payment,
            'Harga_Payment' => $total,
            'Tanggal_Payment' => date('y-m-d'),
        ]);
        DB::table('m_r_p_s')
            ->join('m_p_s', 'm_p_s.ID_MPS', '=', 'm_r_p_s.MPS_ID')
            ->join('boms', 'boms.ID_BOM', '=', 'm_r_p_s.BOM_ID')
            ->join('bahan_bakus', 'bahan_bakus.ID_BahanBaku', '=', 'boms.BahanBaku_ID')
            ->select(DB::raw('SUM(m_r_p_s.POREL) as sum_POREL'),
                'm_p_s.ID_MPS',
                'm_r_p_s.Kode_MRP',
                'm_r_p_s.ID_MRP',
                'm_r_p_s.MPS_ID',
                'm_r_p_s.Produk_ID',
                'm_r_p_s.BOM_ID',
                'm_r_p_s.Tanggal_Pesan',
                'm_r_p_s.Tanggal_Selesai',
                'm_r_p_s.status',
                'boms.BahanBaku_ID',
                'boms.Level_BOM',
                'bahan_bakus.ID_BahanBaku',
                'bahan_bakus.Nama_BahanBaku',
                'bahan_bakus.Satuan_BahanBaku',
                'bahan_bakus.Harga_Satuan'
            )
            ->where('ID_MRP', $ID_MRP->ID_MRP)
            ->where("ID_BahanBaku", $ID_MRP->BOM->BahanBaku_ID)
            ->groupBy('m_p_s.ID_MPS')
            ->where('m_r_p_s.status', '=', 'On-Progress')
            ->update([
                'm_r_p_s.status' => 'Payment-Success',
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

        $mpsON = MPS::with('Produk')->where('status', '!=', 'waiting')->get();
        // $mrp = MRP::with('MPS', 'Produk', 'BOM')->where('status', '=', 'On-Progress')->orderBy('MPS_ID')->paginate(10);

        $mrp = DB::table('m_r_p_s')
            ->join('m_p_s', 'm_p_s.ID_MPS', '=', 'm_r_p_s.MPS_ID')
            ->join('boms', 'boms.ID_BOM', '=', 'm_r_p_s.BOM_ID')
            ->join('bahan_bakus', 'bahan_bakus.ID_BahanBaku', '=', 'boms.BahanBaku_ID')
            ->select(
                DB::raw('SUM(m_r_p_s.POREL) as sum_POREL'),
                'm_p_s.ID_MPS',
                'm_r_p_s.Kode_MRP',
                'm_r_p_s.ID_MRP',
                'm_r_p_s.MPS_ID',
                'm_r_p_s.Produk_ID',
                'm_r_p_s.BOM_ID',
                'm_r_p_s.Tanggal_Pesan',
                'm_r_p_s.Tanggal_Selesai',
                'm_r_p_s.status',
                'boms.BahanBaku_ID',
                'boms.Level_BOM',
                'bahan_bakus.Nama_BahanBaku',
                'bahan_bakus.Satuan_BahanBaku',
                'bahan_bakus.Harga_Satuan'
            )
            ->where('m_r_p_s.status', '=', 'On-Progress')
            ->groupBy('bahan_bakus.Nama_BahanBaku')
            ->groupBy('m_p_s.ID_MPS')
            ->orderBy('m_r_p_s.Tanggal_Selesai')
            ->paginate(10);
        $payment = Payments::with('MRP')->paginate(10);
        // dd($mrp);

        return view('Payment.Tabel.payment', compact('mpsON', 'mrp'));
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
            ->join('m_p_s', 'm_p_s.ID_MPS', '=', 'm_r_p_s.MPS_ID')
            ->join('boms', 'boms.ID_BOM', '=', 'm_r_p_s.BOM_ID')
            ->join('bahan_bakus', 'bahan_bakus.ID_BahanBaku', '=', 'boms.BahanBaku_ID')
            ->select(DB::raw('SUM(m_r_p_s.POREL) as sum_POREL'),
                'm_p_s.ID_MPS',
                'm_r_p_s.Kode_MRP',
                'm_r_p_s.ID_MRP',
                'm_r_p_s.MPS_ID',
                'm_r_p_s.Produk_ID',
                'm_r_p_s.BOM_ID',
                'm_r_p_s.Tanggal_Pesan',
                'm_r_p_s.Tanggal_Selesai',
                'm_r_p_s.status',
                'boms.BahanBaku_ID',
                'boms.Level_BOM',
                'bahan_bakus.ID_BahanBaku',
                'bahan_bakus.Nama_BahanBaku',
                'bahan_bakus.Satuan_BahanBaku',
                'bahan_bakus.Harga_Satuan'
            )
            ->where('ID_MRP', $ID_Payment->MRP_ID)
            ->groupBy('m_p_s.ID_MPS')
            ->update([
                'm_r_p_s.status' => 'On-Progress',
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
