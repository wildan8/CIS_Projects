@extends('main')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Form Data Bahan Baku</h1>
        </div>


        <form action="/Bahanbaku/storeBB" method="POST">
            @csrf
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="form-group col-12">
                                <label>Nama Bahan Baku</label>
                                <input type="text" class="form-control @error('Nama_BahanBaku') is-invalid @enderror"
                                    name="Nama_BahanBaku" value="{{ old('Nama_BahanBaku') }}" Required autofocus>
                                @error('Nama_BahanBaku')
                                    <div class="invalid-feedback">
                                        Isi Dengan Nama Bahan Baku.
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group col-12">
                                <label>Stok</label>
                                <input type="text" class="form-control @error('Stok_BahanBaku') is-invalid @enderror"
                                    name="Stok_BahanBaku" value="{{ old('Stok_BahanBaku') }}" required>
                                @error('Stok_BahanBaku')
                                    <div class="invalid-feedback">
                                        Isi Dengan Stok Bahan Baku.
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group col-12">
                                <label>Harga Satuan</label>
                                <input type="text" class="form-control @error('Harga_Satuan') is-invalid @enderror"
                                    name="Harga_Satuan" value="{{ old('Harga_Satuan') }}" required>
                                @error('Harga_Satuan')
                                    <div class="invalid-feedback">
                                        Isi Dengan Harga Satuan Bahan Baku.
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group col-12">
                                <label>Supplier</label>
                                <select class="form-control" name="Supplier_ID" id="Supplier_ID">
                                    <option disabled value>-- Pilih Supplier --</option>
                                    @foreach ($sup as $s)
                                        <option value="{{ $s->ID_Supplier }}">{{ $s->Nama_Supplier }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-12">
                                <div class="buttons">
                                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection
