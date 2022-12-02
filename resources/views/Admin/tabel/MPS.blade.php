@extends('main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Data Master MPS</h1>
    </div>

    @if (session()->has('statusMPS'))
    <div class="alert alert-success">
        {{session('statusMPS')}}
    </div>
    @endif
    @if (session()->has('hapusMPS'))
    <div class="alert alert-success">
        {{session('hapusMPS')}}
    </div>
    @endif
    @if (session()->has('updateMPS'))
    <div class="alert alert-success">
        {{session('updateMPS')}}
    </div>
    @endif
    <div>
        <a href="/MPS/createMPS" class="btn btn-icon icon-left  btn-primary m-2"><i class="far fa-edit"></i> Tambah
            Data</a>
        {{-- <a href="/MPS/export" class="btn btn-icon icon-left  btn-danger m-2"><i class="far fa-edit"></i> Export
            Data</a> --}}
    </div>
    <form action="/MPS" method="get">
        <div class="input-group mb-3 col-md-4 float-right">
            <input type="text" id="created_at" name="date" class="form-control">
            <div class="input-group-append">
                <button class="btn btn-secondary" type="submit">Filter</button>
            </div>
            <a target="_blank" class="btn btn-primary ml-2" id="exportpdf">Export PDF</a>
        </div>
    </form>
    <div class="section-body">
        <div class="card">
            <div class="table-responsive p-2">
                <table class=" table table-striped table-md">
                    <thead>
                        <tr>
                            <th scope="col">Kode</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Ukuran</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">tanggal Pesan</th>
                            <th scope="col">Status</th>
                            <th scope="col">aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mps as $mps)
                        <tr>
                            <td>{{ $mps->Kode_MPS }}</td>
                            <td>{{ $mps->Produk->Nama_Produk ?? '-' }}</td>
                            <td>{{ $mps->Ukuran_Produk }}</td>
                            <td>{{ $mps->Jumlah_MPS }}</td>
                            <td>{{ $mps->Tanggal_MPS }}</td>
                            <td>
                                @if ($mps ->status == 'Payment-Success')
                                <div class="badge badge-primary">{{ $mps ->status }}</div>
                                @elseif($mps ->status == 'On-Progress')
                                <div class="badge badge-info">{{ $mps ->status }}</div>
                                @elseif($mps ->status == 'Production')
                                <div class="badge badge-warning">{{ $mps ->status }}</div>
                                @elseif($mps ->status == 'Done')
                                <div class="badge badge-success">{{ $mps ->status }}</div>
                                @endif
                            </td>
                            <td>
                                <a href="/MPS/deleteMPS/{{$mps->ID_MPS}}" class="btn btn-icon btn-danger" onclick="return confirm('Apakah Yakin ingin Menghapus Data?')"><i class="fas fa-times"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <div class="section-body">
    </div>
</section>
@endsection
@push('js-internal')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script>
    //KETIKA PERTAMA KALI DI-LOAD MAKA TANGGAL NYA DI-SET TANGGAL SAA PERTAMA DAN TERAKHIR DARI BULAN SAAT INI
    $(document).ready(function() {
        let start = moment().startOf('month')
        let end = moment().endOf('month')

        //KEMUDIAN TOMBOL EXPORT PDF DI-SET URLNYA BERDASARKAN TGL TERSEBUT
        $('#exportpdf').attr('href', '/MPS/export/' + start.format('YYYY-MM-DD') + '+' + end.format('YYYY-MM-DD'))

        //INISIASI DATERANGEPICKER
        $('#created_at').daterangepicker({
            startDate: start
            , endDate: end
        }, function(first, last) {
            //JIKA USER MENGUBAH VALUE, MANIPULASI LINK DARI EXPORT PDF
            $('#exportpdf').attr('href', '/MPS/export/' + first.format('YYYY-MM-DD') + '+' + last.format('YYYY-MM-DD'))
        })
    })

</script>
@endpush
