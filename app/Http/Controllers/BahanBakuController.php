<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\StoreBahanBakuRequest;
use App\Http\Requests\UpdateBahanBakuRequest;
use App\Models\BahanBaku;
use App\Models\MPS;
use App\Models\MRP;
use App\Models\Penerimaan;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class BahanBakuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $bahanbaku = BahanBaku::with('Supplier')->paginate(10);

        // dd($bahanbaku);
        return view('gudang.tabel.bahanbaku', compact('bahanbaku'));

    }

    public function Gudang()
    {
        $start = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
        $end = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');
        if (request()->date != '') {
            $date = explode(' - ', request()->date);
            $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
            $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';
        }
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
                'bahan_bakus.ID_BahanBaku',
                'bahan_bakus.Nama_BahanBaku',
                'bahan_bakus.Satuan_BahanBaku',
                'bahan_bakus.Harga_Satuan'
            )
            ->where('m_r_p_s.status', '=', 'Payment-Success')
            ->whereBetween('m_r_p_s.Tanggal_Selesai', [$start, $end])
            ->groupBy('bahan_bakus.Nama_BahanBaku')
            ->groupBy('m_r_p_s.Tanggal_Pesan')
            ->paginate(10);

        $mpsON = MPS::with('Produk')->where('status', '!=', 'Waiting')->whereBetween('Tanggal_MPS', [$start, $end])->paginate(10);

        $mpsW = MPS::with('Produk')->where('status', '=', 'waiting')->get();

        return view('gudang.home', compact('mpsW', 'mpsON', 'mrp'));

    }
    public function GudangPer()
    {
        $start = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
        $end = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');
        if (request()->date != '') {
            $date = explode(' - ', request()->date);
            $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
            $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';
        }
        $mpsON = DB::table('m_r_p_s')
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
                'bahan_bakus.ID_BahanBaku',
                'bahan_bakus.Nama_BahanBaku',
                'bahan_bakus.Satuan_BahanBaku',
                'bahan_bakus.Harga_Satuan'
            )
            ->where('m_r_p_s.status', '=', 'Payment-Success')
            ->whereBetween('m_r_p_s.Tanggal_Selesai', [$start, $end])
            ->groupBy('bahan_bakus.Nama_BahanBaku')
            ->groupBy('m_r_p_s.Tanggal_Pesan')
            ->paginate(10);

        $mpsON = MPS::with('Produk')->where('status', '!=', 'Waiting')->whereBetween('Tanggal_MPS', [$start, $end])->paginate(10);

        $mpsW = MPS::with('Produk')->where('status', '=', 'waiting')->get();

        return view('gudang.homePesanan', compact('mpsW', 'mpsON', 'mrp'));

    }
    public function proses(MRP $ID_MRP)
    {
        $Kode_LOG = Helper::IDGenerator(new Penerimaan, 'ID_LOG', 'Kode_LOG', 2, 'LOGTRM-' . $ID_MRP->BOM->BahanBaku->ID_BahanBaku . '-' . date('ymd'));
        Penerimaan::insert([
            'Kode_LOG' => $Kode_LOG,
            'BahanBaku_ID' => $ID_MRP->BOM->BahanBaku->ID_BahanBaku,
            'Jumlah_LOG' => $ID_MRP->GR,
            'Tanggal_LOG' => date('y-m-d'),
            'Status_LOG' => 'Di Terima',
        ]);
        $Kode_LOG = Helper::IDGenerator(new Penerimaan, 'ID_LOG', 'Kode_LOG', 2, 'LOGISS-' . $ID_MRP->BOM->BahanBaku->ID_BahanBaku . '-' . date('ymd'));
        Penerimaan::insert([
            'Kode_LOG' => $Kode_LOG,
            'BahanBaku_ID' => $ID_MRP->BOM->BahanBaku->ID_BahanBaku,
            'Jumlah_LOG' => $ID_MRP->GR,
            'Tanggal_LOG' => date('y-m-d'),
            'Status_LOG' => 'Issuing',
        ]);
        DB::table('m_r_p_s')
            ->where('ID_MRP', $ID_MRP->ID_MRP)
            ->update([
                'status' => 'Production',
            ]);

        // dd($mrp);
        return back();
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
        // return $request->file('image')->store('BahanBaku-images');
        $validatedData = $request->validate([
            'Nama_BahanBaku' => 'required',
            'Satuan_BahanBaku' => 'required',
            'Leadtime_BahanBaku' => 'required|integer',

            'Harga_Satuan' => 'required|integer',
            'Supplier_ID' => 'required',
        ]);
        $Kode_BahanBaku = Helper::IDGenerator(new BahanBaku, 'ID_BahanBaku', 'Kode_BahanBaku', 2, 'BB' . substr($request->Nama_BahanBaku, -2) . '-SUP' . $request->Supplier_ID);
        // dd($Kode_BahanBaku);
        BahanBaku::insert([
            'Kode_BahanBaku' => $Kode_BahanBaku,
            'Nama_BahanBaku' => $request->Nama_BahanBaku,
            'Satuan_BahanBaku' => $request->Satuan_BahanBaku,
            'Leadtime_BahanBaku' => $request->Leadtime_BahanBaku,
            'Harga_Satuan' => $request->Harga_Satuan,
            'Supplier_ID' => $request->Supplier_ID,

        ]);
        return redirect('/Bahanbaku')->with('statusBahanBaku', 'Input Data Bahanbaku Berhasil!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BahanBaku  $bahanBaku
     * @return \Illuminate\Http\Response
     */
    public function showPesanan(MPS $ID_MPS, MRP $MRP)
    {
        $mrp = MRP::where('MPS_ID', '=', $ID_MPS->ID_MPS)->orderBy("Tanggal_pesan")->get();
        $mps = MPS::with('Produk')->where('ID_MPS', '=', $ID_MPS->ID_MPS)->first();

        return view('gudang.perPesanan', compact('mps', 'mrp'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BahanBaku  $bahanBaku
     * @return \Illuminate\Http\Response
     */
    public function test(BahanBaku $ID_BahanBaku)
    {
        $BB = BahanBaku::with("Supplier")->where("ID_BahanBaku", "=", $ID_BahanBaku->ID_BahanBaku)->first();
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
                'Nama_BahanBaku' => $request->Nama_BahanBaku,
                'Satuan_BahanBaku' => $request->Satuan_BahanBaku,
                'Leadtime_BahanBaku' => $request->Leadtime_BahanBaku,
                'Stok_BahanBaku' => $request->Stok_BahanBaku,
                'Harga_Satuan' => $request->Harga_Satuan,
                'Supplier_ID' => $request->Supplier_ID,
            ]);
        return redirect('/Bahanbaku');
    }
    public function filter()
    {
        $start = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
        $end = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');
        if (request()->date != '') {
            $date = explode(' - ', request()->date);
            $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
            $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';
        }
        $mrp = MRP::with('MPS', 'Produk', 'BOM')->whereBetween('Tanggal_Pesan', [$start, $end])->paginate(10);
        $mpsON = DB::table('m_r_p_s')
            ->join('m_p_s', 'm_p_s.ID_MPS', '=', 'm_r_p_s.MPS_ID')
            ->join('boms', 'boms.ID_BOM', '=', 'm_r_p_s.BOM_ID')
            ->join('bahan_bakus', 'bahan_bakus.ID_BahanBaku', '=', 'boms.BahanBaku_ID')
            ->select(
                DB::raw('SUM(m_r_p_s.POREL) as sum_POREL'),
                'm_p_s.ID_MPS',
                'm_p_s.Kode_MPS',
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
            ->where('m_r_p_s.status', '=', 'Payment-Success')
            ->whereBetween('m_r_p_s.Tanggal_Selesai', [$start, $end])
            ->groupBy('bahan_bakus.Nama_BahanBaku')
            ->groupBy('m_r_p_s.Tanggal_Pesan')
            ->paginate(10);
        $mpsW = MPS::with('Produk')->where('status', '=', 'waiting')->get();
        return view('gudang.homePesanan', compact('mpsW', 'mpsON', 'mrp'));
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
    public function PDF()
    {
        $data = BahanBaku::with('Supplier')->get();
        // dd($BahanBaku);
        $Judul = 'List Data Bahan Baku';
        $jenis = 'bahanbaku';
        $Tanggal = date('Y-m-d H:i:s');
        $Jumlah = BahanBaku::count();
        $pdf = PDF::loadView('Laporan.BahanBaku', compact('data', 'Judul', 'Tanggal', 'jenis', 'Jumlah'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream('LIST DATA BAHAN BAKU-' . date('ymd') . '.pdf');
    }

    public function exportFirst(MPS $ID_MPS, MRP $MRP)
    {

        $mrp = MRP::where('MPS_ID', '=', $ID_MPS->ID_MPS)->orderBy("Tanggal_pesan")->get();
        $mrpTanggal = MRP::where('MPS_ID', '=', $ID_MPS->ID_MPS)->orderByDesc("Tanggal_Selesai")->first();
        $mps = MPS::with('Produk')->where('ID_MPS', '=', $ID_MPS->ID_MPS)->first();
        $Judul = 'Pesanan-' . $mps->Produk->Nama_Produk;
        $Tanggal = date('Y-m-d H:i:s');
        $Jumlah = MRP::where('MPS_ID', '=', $ID_MPS->ID_MPS)->orderBy("Tanggal_pesan")
            ->count();
        $pdf = PDF::loadView('Laporan.MRPFirst', compact('mrp', 'mrpTanggal', 'mps', 'Judul', 'Tanggal', 'Jumlah'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream('MRP-Laporan Kebutuhan-' . $mps->Produk->Nama_Produk . '-' . date('ymd') . '.pdf');
    }
    public function exportAll(MRP $MRP, $daterange)
    {
        $date = explode('+', $daterange);
        $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
        $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';
        $jenis = 'ALLBB';
        $Judul = $jenis . '-ALL-LIST';
        $Tanggal = date('Y-m-d H:i:s');
        $mrp = DB::table('m_r_p_s')
            ->join('m_p_s', 'm_p_s.ID_MPS', '=', 'm_r_p_s.MPS_ID')
            ->join('boms', 'boms.ID_BOM', '=', 'm_r_p_s.BOM_ID')
            ->join('bahan_bakus', 'bahan_bakus.ID_BahanBaku', '=', 'boms.BahanBaku_ID')
            ->select(
                DB::raw('SUM(m_r_p_s.POREL) as sum_POREL'),
                'm_p_s.ID_MPS',
                'm_p_s.Kode_MPS',
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
            ->groupBy('bahan_bakus.Nama_BahanBaku')
            ->groupBy('m_p_s.ID_MPS')
            ->get();
        $mpsON = MPS::with('Produk')->where('status', '!=', 'waiting')->whereBetween('Tanggal_MPS', [$start, $end])->get();
        $Jumlah = MRP::with('MPS', 'Produk', 'BOM')->orderBy("Tanggal_pesan")
            ->count();
        $pdf = PDF::loadView('Laporan.MRPAll', compact('mrp', 'mpsON', 'Judul', 'Tanggal', 'Jumlah', 'jenis', 'start', 'end'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream($jenis . '-LIST' . '-' . date('ymd') . '.pdf');
    }
    public function kebutuhanPDF($daterange)
    {
        $date = explode('+', $daterange);
        $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
        $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';
        $jenis = 'KEBUTUHAN';
        $Judul = $jenis . '-ALL-LIST';
        $Tanggal = date('Y-m-d H:i:s');
        $mrp = DB::table('m_r_p_s')
            ->join('m_p_s', 'm_p_s.ID_MPS', '=', 'm_r_p_s.MPS_ID')
            ->join('boms', 'boms.ID_BOM', '=', 'm_r_p_s.BOM_ID')
            ->join('bahan_bakus', 'bahan_bakus.ID_BahanBaku', '=', 'boms.BahanBaku_ID')
            ->select(
                DB::raw('SUM(m_r_p_s.POREL) as sum_POREL'),
                'm_p_s.ID_MPS',
                'm_p_s.Kode_MPS',
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
            ->groupBy('bahan_bakus.Nama_BahanBaku')

            ->get();
        $mpsON = MPS::with('Produk')->where('status', '!=', 'waiting')->whereBetween('Tanggal_MPS', [$start, $end])->get();
        $Jumlah = MRP::with('MPS', 'Produk', 'BOM')->orderBy("Tanggal_pesan")
            ->count();
        $pdf = PDF::loadView('Laporan.BahanBaku', compact('mrp', 'mpsON', 'Judul', 'Tanggal', 'Jumlah', 'jenis', 'start', 'end'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream($jenis . '-LIST' . '-' . date('ymd') . '.pdf');

    }
}
