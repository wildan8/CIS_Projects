@extends('main')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Form Data Supplier</h1>
        </div>


        <form action="/Supplier/storeSUP" method="POST">
            @csrf
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="form-group col-12">
                                <label>Nama Usaha Supplier</label>
                                <input type="text" name="Nama_Supplier"
                                    class="form-control @error('Nama_Supplier') is-invalid @enderror"
                                    value="{{ old('Nama_Supplier') }}" required autofocus>
                                @error('Nama_Supplier')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group col-12">
                                <label>Pemilik Supplier</label>
                                <input type="text" name="Pemilik_Supplier"
                                    class="form-control @error('Pemilik_Supplier') is-invalid @enderror"
                                    value="{{ old('Pemilik_Supplier') }}" required>
                                @error('Pemilik_Supplier')
                                    <div class="invalid-feedback">
                                        Isi Dengan Nama Pemilik/Penanggung jawab Supplier.
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group col-12">
                                <label>Alamat Supplier</label>
                                <input type="text" name="Alamat_Supplier"
                                    class="form-control @error('Alamat_Supplier') is-invalid @enderror"
                                    value="{{ old('Alamat_Supplier') }}" required>
                                @error('Alamat_Supplier')
                                    <div class="invalid-feedback">
                                        Isi Dengan Alamat Usaha Supplier.
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group col-12">
                                <label>No. Telepon Supplier</label>
                                <input type="text" name="Telp_Supplier"
                                    class="form-control @error('Telp_Supplier') is-invalid @enderror"
                                    value="{{ old('Telp_Supplier') }}" required>
                                @error('Telp_Supplier')
                                    <div class="invalid-feedback">
                                        Isi Dengan Nomor Telp Pemilik/Penanggung Jawab Supplier.
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group col-12">
                                <div class="buttons">
                                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                                </div>
                            </div>

                            <!-- <div class="form-group" type="submit">
                <a href="/Supplier/storeSUP" class="btn btn-primary">Primary</a>
              </div> -->

                        </div>
                    </div>
                </div>
            </div>
        </form>

    </section>
@endsection
