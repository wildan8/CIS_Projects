@extends('main')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Form Data Penerimaan Bahan Baku</h1>
        </div>

        <form action="/LOG/storeLOG" method="post">
            @csrf
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="form-group col-12">
                                <label>Nama Bahan Baku</label>
                                <select class="form-control" name="BahanBaku_ID">
                                    <option disabled value>-- Pilih Bahan Baku --</option>
                                    @foreach ($BB as $BB)
                                        <option value="{{ $BB->ID_BahanBaku }}">{{ $BB->Nama_BahanBaku }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-12">
                                <label>Jumlah</label>
                                <input type="text" class="form-control @error('Jumlah_LOG') is-invalid @enderror"
                                    name="Jumlah_LOG" value="{{ old('Jumlah_LOG') }}" required>
                                @error('Jumlah_LOG')
                                    <div class="invalid-feedback">
                                        Isi Dengan Jumlah Bahan Baku.
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group col-12">
                                <label>Tanggal</label>
                                <input type="date" class="form-control @error('Tanggal_LOG') is-invalid @enderror"
                                    name="Tanggal_LOG" value="{{ old('Tanggal_LOG') }}" required>
                                @error('Tanggal_LOG')
                                    <div class="invalid-feedback">
                                        Isi Dengan Tanggal Penerimaan/Pemakaian Bahan Baku.
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group col-12">
                                <label>Status LOG Bahan Baku</label>
                                <select class="form-control" name="Status_LOG">
                                    <option disabled value>-- Pilih Status --</option>
                                    <option value="Terima">Penerimaan Bahan Baku</option>
                                    <option value="Issuing">Pemakaian Bahan Baku</option>

                                </select>
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
