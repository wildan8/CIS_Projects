@extends('main')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Form Data Bill of Material</h1>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/BOM/storeBOM" method="post">
            @csrf
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="form-group col-12">
                                <label>Produk</label>
                                <select class="form-control" name="Produk_ID" id="Produk_ID">
                                    <option disabled value>-- Pilih Produk --</option>
                                    @foreach ($PROD as $s)
                                        <option value="{{ $s->ID_Produk }}">
                                            {{ $s->Nama_Produk . ' ( ' . $s->Ukuran_Produk . ' ) ' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-12">
                                <label>Bahan Baku</label>
                                <select class="form-control" name="BahanBaku_ID" id="BahanBaku_ID">
                                    <option disabled value>-- Pilih Bahan Baku --</option>
                                    @foreach ($BB as $bb)
                                        <option value="{{ $bb->ID_BahanBaku }}">{{ $bb->Nama_BahanBaku }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-12">
                                <label>Jumlah</label>
                                <input type="text" name="Jumlah_BOM"
                                    class="form-control @error('Jumlah_BOM') is-invalid @enderror">
                                @error('Jumlah_BOM')
                                    <div class="invalid-feedback">
                                        Isi Dengan Jumlah Produk.
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group col-12">
                                <label>Ukuran Produk</label>
                                <input type="text" name="Ukuran_Produk"
                                    class="form-control @error('Ukuran_Produk') is-invalid @enderror">
                                @error('Ukuran_Produk')
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
