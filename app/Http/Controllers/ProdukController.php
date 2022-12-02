<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\StoreProdukRequest;
use App\Http\Requests\UpdateProdukRequest;
use App\Models\MPS;
use App\Models\MRP;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produk = DB::table('produks')->paginate(10);
        return view('produksi.tabel.produk', ['produk' => $produk]);
    }
    public function Home()
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

        $mpsON = MPS::with('Produk')->where('status', '=', 'On-Progress')->whereBetween('Tanggal_MPS', [$start, $end])->paginate(10);
        $mrp = MRP::with('MPS', 'Produk', 'BOM')->whereBetween('Tanggal_Pesan', [$start, $end])->paginate(10);

        return view('produksi.home', compact('mpsON', 'mrp'));
    }
    public function ProduksiDone()
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

        $mpsON = MPS::with('Produk')->where('status', '=', 'Done')->whereBetween('Tanggal_MPS', [$start, $end])->paginate(10);
        $mrp = MRP::with('MPS', 'Produk', 'BOM')->whereBetween('Tanggal_Pesan', [$start, $end])->paginate(10);

        return view('Produksi.ProduksiDone', compact('mpsON', 'mrp'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('produksi.forms.produk');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProdukRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProdukRequest $request)
    {
        $validatedData = $request->validate([
            'Nama_Produk' => 'required|max:255',
            'Ukuran_Produk' => 'required|max:5',
            'Leadtime_Assembly' => 'required|integer',
        ]);
        $Kode_Produk = Helper::IDGenerator(new Produk, 'ID_Produk', 'Kode_Produk', 2, 'PROD-' . substr($request->Nama_Produk, -2) . $request->Ukuran_Produk);
        Produk::insert([
            'Kode_Produk' => $Kode_Produk,
            'Nama_Produk' => $request->Nama_Produk,
            'Ukuran_Produk' => $request->Ukuran_Produk,
            'Leadtime_Assembly' => $request->Leadtime_Assembly,
            'Level_BOM' => 0,
        ]);

        return redirect('/produk')->with('statusProduk', 'Input Data Produk Berhasil!');
        // DB::table('produks')-> insert([
        //     'Nama_Produk' => $request -> Nama_Produk,
        //     'Ukuran_Produk' => $request -> Ukuran_Produk,
        //     'Jumlah_Produk' => $request -> Jumlah_Produk,
        // ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function show(Produk $produk, MPS $ID_MPS)
    {
        $mrp = MRP::where('MPS_ID', '=', $ID_MPS->ID_MPS)->orderBy("Tanggal_pesan")->get();
        $mps = MPS::with('Produk')->where('ID_MPS', '=', $ID_MPS->ID_MPS)->first();

        return view('produksi.edits.KebPROD', compact('mps', 'mrp'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function edit(Produk $ID_Produk)
    {
        $produk = collect(Produk::find($ID_Produk))->first();
        // dd($produk);
        return view('produksi.edits.produk', compact('produk'));
    }
    public function accept(Produk $produk, MPS $ID_MPS)
    {
        DB::table('m_p_s')
            ->where('ID_MPS', $ID_MPS->ID_MPS)
            ->update([
                'status' => 'Done',
            ]);
        DB::table('m_r_p_s')
            ->where('MPS_ID', $ID_MPS->ID_MPS)
            ->update([
                'status' => 'Done',
            ]);
        // dd($produk);
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProdukRequest  $request
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProdukRequest $request, Produk $ID_Produk)
    {
        $validatedData = $request->validate([
            'Nama_Produk' => 'required',
            'Ukuran_Produk' => 'required',
            'Leadtime_Assembly' => 'required|integer',
        ]);

        Produk::where('ID_Produk', $request->ID_Produk)
            ->update($validatedData);
        return redirect('/produk')->with('updateProduk', 'Data Produk Berhasil Diupdate!');
        // DB::table('produks')
        // ->where('ID_Produk', $request -> ID_Produk)
        // ->update([
        //     'Nama_Produk' => $request -> Nama_Produk,
        //     'Ukuran_Produk' => $request -> Ukuran_Produk,
        //     'Jumlah_Produk' => $request -> Jumlah_Produk

        // ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produk $ID_Produk)
    {
        $produkDEL = Produk::find($ID_Produk);
        $produkDEL->each->delete();
        return redirect('/produk')->with('statusProduk', 'Hapus Data Produk Berhasil!');
    }
    public function PDF()
    {
        $data = Produk::all();
        // dd($Produk);
        $Judul = 'List Data Produk';
        $Tanggal = date('Y-m-d H:i:s');
        $Jumlah = Produk::count();
        $pdf = PDF::loadView('Laporan.Produk', compact('data', 'Judul', 'Tanggal', 'Jumlah'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream('LIST DATA Produk-' . date('ymd') . '.pdf');
    }
    public function exportAll($daterange)
    {

        $date = explode('+', $daterange); //EXPLODE TANGGALNYA UNTUK MEMISAHKAN START & END
        //DEFINISIKAN VARIABLENYA DENGAN FORMAT TIMESTAMPS
        $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
        $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';
        $jenis = "ALLPROD";
        $Judul = $jenis . '-ALL-LIST';
        $Tanggal = date('Y-m-d H:i:s');
        //KEMUDIAN BUAT QUERY BERDASARKAN RANGE CREATED_AT YANG TELAH DITETAPKAN RANGENYA DARI $START KE $END
        // $mrp = MRP::with('MPS', 'Produk', 'BOM')->whereBetween('Tanggal_Pesan', [$start, $end])->get();
        // $mpsON = MPS::with('Produk')->where('status', '!=', 'waiting')->whereBetween('Tanggal_MPS', [$start, $end])->get();
        $mpsON = MPS::with('Produk')->where('status', '=', 'On-Progress')->get();
        $mrp = MRP::with('MPS', 'Produk', 'BOM')->get();
        // dd($distTanggal);
        $Jumlah = MRP::with('MPS', 'Produk', 'BOM')->orderBy("Tanggal_pesan")
            ->count();
        $pdf = PDF::loadView('Laporan.MRPAll', compact('mrp', 'mpsON', 'Judul', 'Tanggal', 'Jumlah', 'jenis', 'start', 'end'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream($jenis . '-LIST' . '-' . date('ymd') . '.pdf');

    }

    public function exportAllDone($daterange)
    {
        $date = explode('+', $daterange); //EXPLODE TANGGALNYA UNTUK MEMISAHKAN START & END
        //DEFINISIKAN VARIABLENYA DENGAN FORMAT TIMESTAMPS
        $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
        $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';
        $jenis = "ALLPROD";
        $Judul = $jenis . '-DONE-LIST';
        $Tanggal = date('Y-m-d H:i:s');
        //KEMUDIAN BUAT QUERY BERDASARKAN RANGE CREATED_AT YANG TELAH DITETAPKAN RANGENYA DARI $START KE $END
        // $mrp = MRP::with('MPS', 'Produk', 'BOM')->whereBetween('Tanggal_Pesan', [$start, $end])->get();
        // $mpsON = MPS::with('Produk')->where('status', '!=', 'waiting')->whereBetween('Tanggal_MPS', [$start, $end])->get();
        $mpsON = MPS::with('Produk')->where('status', '=', 'Done')->orderByDesc('Tanggal_MPS')->get();
        $mrp = MRP::with('MPS', 'Produk', 'BOM')->get();
        // dd($distTanggal);
        $Jumlah = MRP::with('MPS', 'Produk', 'BOM')->orderBy("Tanggal_pesan")
            ->count();
        $pdf = PDF::loadView('Laporan.MRPAll', compact('mrp', 'mpsON', 'Judul', 'Tanggal', 'Jumlah', 'jenis', 'start', 'end'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream($jenis . '-LIST' . '-' . date('ymd') . '.pdf');
    }

}
