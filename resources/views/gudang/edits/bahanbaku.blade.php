@extends('main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Edit Data Bahan Baku</h1>
    </div>


    <form action="/Bahanbaku/perbaru" method="POST">
        @csrf
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <input type="text" class="form-control @error('IDBB') is-invalid @enderror" name="IDBB" value="{{ $BB->ID_BahanBaku }}" hidden>
                        <div class="form-group col-12">
                            <label>Nama Bahan Baku</label>
                            <input type="text" class="form-control @error('Nama_BahanBaku') is-invalid @enderror" name="Nama_BahanBaku" value="{{ $BB->Nama_BahanBaku }}" Required autofocus>
                            @error('Nama_BahanBaku')
                            <div class="invalid-feedback">
                                Isi Dengan Nama Bahan Baku.
                            </div>
                            @enderror
                        </div>
                        <div class="form-row col-12">
                            <div class="form-group col-md-4">
                                <label>Stok</label>
                                <input type="text" class="form-control @error('Stok_BahanBaku') is-invalid @enderror" name="Stok_BahanBaku" value="{{ $BB->Stok_BahanBaku }}" required>
                                @error('Stok_BahanBaku')
                                <div class="invalid-feedback">
                                    Isi Dengan Stok Bahan Baku.
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Satuan Bahan Baku</label>
                                <input type="text" class="form-control @error('Satuan_BahanBaku') is-invalid @enderror" name="Satuan_BahanBaku" value="{{ $BB->Satuan_BahanBaku }}" required>
                                @error('Satuan_BahanBaku')
                                <div class="invalid-feedback">
                                    Isi Dengan Satuan Bahan Baku.
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Leadtime Bahan Baku (hari)</label>
                                <input type="text" class="form-control @error('Leadtime_BahanBaku') is-invalid @enderror" name="Leadtime_BahanBaku" value="{{ $BB->Leadtime_BahanBaku }}" required>
                                @error('Leadtime_BahanBaku')
                                <div class="invalid-feedback">
                                    Isi Dengan waktu tunggu hari Bahan Baku.
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group col-12">
                            <label>Harga Satuan</label>
                            <input type="text" class="form-control @error('Harga_Satuan') is-invalid @enderror" name="Harga_Satuan" value="{{ $BB->Harga_Satuan }}" required>
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
