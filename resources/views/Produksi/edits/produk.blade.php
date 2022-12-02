@extends('main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Form Data Produk</h1>
    </div>

    <form action="/produk/updatePROD" method="post">
        @csrf
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <input type="hidden" value="{{ $produk->ID_Produk }}" name="ID_Produk">
                        <div class="form-group col-12">
                            <label>Nama Produk</label>
                            <input type="text" class="form-control @error('Nama_Produk') is-invalid @enderror" name="Nama_Produk" value="{{ old('Nama_Produk', $produk->Nama_Produk) }}">
                            @error('Nama_Produk')
                            <div class="invalid-feedback">
                                Isi Dengan Nama Produk.
                            </div>
                            @enderror
                        </div>
                        <div class="form-group col-12">
                            <label>Ukuran</label>
                            <input type="text" class="form-control @error('Ukuran_Produk') is-invalid @enderror" name="Ukuran_Produk" value="{{ old('Ukuran_Produk', $produk->Ukuran_Produk) }}">
                            @error('Ukuran_Produk')
                            <div class="invalid-feedback">
                                Isi Dengan Ukuran Produk.
                            </div>
                            @enderror
                        </div>
                        <div class="form-group col-12">
                            <label>Leadtime Assembly</label>
                            <input type="text" class="form-control @error('Leadtime_Assembly') is-invalid @enderror" name="Leadtime_Assembly" value="{{ old('Leadtime_Assembly', $produk->Leadtime_Assembly) }}">
                            @error('Leadtime_Assembly')
                            <div class="invalid-feedback">
                                Isi Dengan lama waktu Assembly Produk.
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
