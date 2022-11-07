@extends('main')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Form Data Produk</h1>
        </div>
        <form action="/produk/storePROD" method="post">
            @csrf
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="form-group col-12">
                                <label>Nama Produk</label>
                                <input type="text" class="form-control @error('Nama_Produk') is-invalid @enderror"
                                    name="Nama_Produk" value="{{ old('Nama_Produk') }}" required autofocus>
                                @error('Nama_Produk')
                                    <div class="invalid-feedback">
                                        Isi Dengan Nama Produk.
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group col-12">
                                <label>Ukuran</label>
                                <input type="text" class="form-control @error('Ukuran_Produk') is-invalid @enderror"
                                    name="Ukuran_Produk" value="{{ old('Ukuran_Produk') }}" required>
                                @error('Ukuran_Produk')
                                    <div class="invalid-feedback">
                                        Isi Dengan Ukuran Produk.
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group col-12">
                                <label>Jumlah</label>
                                <input type="text" class="form-control @error('Jumlah_Produk') is-invalid @enderror"
                                    name="Jumlah_Produk" value="{{ old('Jumlah_Produk') }}" required>
                                @error('Jumlah_Produk')
                                    <div class="invalid-feedback">
                                        Isi Dengan Jumlah Produk.
                                    </div>
                                @enderror
                            </div>
                            <div class="buttons col-12">
                                <button type="submit" class="btn btn-primary">Simpan Data</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </form>

    </section>
@endsection
