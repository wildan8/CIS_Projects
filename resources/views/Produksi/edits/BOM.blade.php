@extends('main')
@section('content')
<section class="section">
    @if (session()->has('statusBOM'))
    <div class="alert alert-success">
        {{ session('statusBOM') }}
    </div>
    @endif
    @if (session()->has('hapusBOM'))
    <div class="alert alert-danger">
        {{ session('hapusBOM') }}
    </div>
    @endif
    @if (session()->has('updateBOM'))
    <div class="alert alert-success">
        {{ session('updateBOM') }}
    </div>
    @endif
    <div class="section-header">
        <h1>Form Isi Data BOM</h1>
    </div>
    <div class="section-header">
        <a href="/BOM">
            <-- Kembali</a>
    </div>
    <form action="/BOM/storeBOM" method="post">
        @csrf
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <input type="text" class="form-control" name="Produk_ID" value="{{ $Produk->ID_Produk }}" hidden>

                        <div class="form-group col-12">
                            <label>Nama Produk</label>
                            <input type="text" class="form-control" name="Nama_Produk" value="{{ $Produk->Nama_Produk }}" disabled>

                        </div>
                        <div class="form-group col-12">
                            <label>Ukuran</label>
                            <input type="text" class="form-control" name="Ukuran_Tampil" value="{{ $Produk->Ukuran_Produk }}" disabled>
                            <input type="text" class="form-control" name="Ukuran_Produk" value="{{ $Produk->Ukuran_Produk }}" hidden>
                        </div>

                        <div class="form-group col-12">
                            <label>Nama Bahan Baku</label>
                            <select class="form-control" name="BahanBaku_ID" id="BahanBaku_ID">
                                <option disabled value>-- Pilih Bahan Baku --</option>
                                @foreach ($BB as $BB)
                                <option value="{{ $BB->ID_BahanBaku }}">{{ $BB->Nama_BahanBaku }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-12">
                            <label>Jumlah</label>
                            <input type="text" class="form-control @error('Jumlah_BOM') is-invalid @enderror" name="Jumlah_BOM" required>
                            @error('Jumlah_BOM')
                            <div class="invalid-feedback">
                                Isi Dengan Jumlah Produk.
                            </div>
                            @enderror
                        </div>

                        <div class="buttons col-12">
                        </div>
                        <div>
                            <button type="submit" class="btn m-2  btn-primary">Simpan Data</button>
                            <a href="/produk/export" class="btn btn-icon icon-right  m-2 btn-danger"> Export
                                Data</a>
                        </div>
                        <!-- table Page -->
                        <div class="section-body">
                            <div class="card">
                                <div class="table-responsive p-2">
                                    <table class="  table table-striped table-md ">
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Nama Bahan Baku</th>
                                                <th scope="col">Jumlah</th>
                                                <th scope="col">aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($BOM as $BOM)
                                            <tr>
                                                <td>{{ $BOM->Kode_BOM }}</td>
                                                <td>{{ $BOM->BahanBaku->Nama_BahanBaku }}</td>
                                                <td>{{ $BOM->Jumlah_BOM }}</td>

                                                <td>
                                                    <a href="/BOM/deleteBOM/{{ $BOM->ID_BOM }}" class="btn btn-icon btn-danger" onclick="return confirm('Apakah Yakin ingin Menghapus Data?')"><i class="fas fa-times"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        <!-- End Table Page -->
                    </div>
                </div>
            </div>
        </div>
    </form>

</section>
@endsection
