@extends('main')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Update Data Supplier</h1>
        </div>


        <form action="/Supplier/updateSUP" method="POST">
            @csrf
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <input type="hidden" value="{{ $supplier->ID_Supplier }}" name="ID_Supplier">
                            <div class="form-group col-12">
                                <label>Nama Usaha</label>
                                <input type="text" name="Nama_Supplier"
                                    class="form-control @error('Nama_Supplier') is-invalid @enderror"
                                    value="{{ old('Nama_Supplier', $supplier->Nama_Supplier) }}">
                                @error('Nama_Supplier')
                                    <div class="invalid-feedback">
                                        Isi Dengan Nama Usaha Supplier.
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group col-12">
                                <label>Pemilik Usaha</label>
                                <input type="text" name="Pemilik_Supplier"
                                    class="form-control @error('Pemilik_Supplier') is-invalid @enderror"
                                    value="{{ old('Pemilik_Supplier', $supplier->Pemilik_Supplier) }}">
                                @error('Pemilik_Supplier')
                                    <div class="invalid-feedback">
                                        Isi Dengan Pemilik/Penanggung Jawab Supplier.
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group col-12">
                                <label>Alamat Usaha</label>
                                <input type="text" name="Alamat_Supplier"
                                    class="form-control @error('Alamat_Supplier') is-invalid @enderror"
                                    value="{{ old('Alamat_Supplier', $supplier->Alamat_Supplier) }}">
                                @error('Alamat_Supplier')
                                    <div class="invalid-feedback">
                                        Isi Dengan Pemilik/Penanggung Jawab Supplier.
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group col-12">
                                <label>No. Telepon Penanggung Jawab</label>
                                <input type="text" name="Telp_Supplier"
                                    class="form-control @error('Telp_Supplier') is-invalid @enderror"
                                    value="{{ old('Telp_Supplier', $supplier->Telp_Supplier) }}">
                                @error('Telp_Supplier')
                                    <div class="invalid-feedback">
                                        Isi Dengan Telp Supplier.
                                    </div>
                                @enderror
                            </div>
                            <div class="buttons col-12">
                                <button type="submit" class="btn btn-primary">Simpan Data</button>
                            </div>

                            <!-- <div class="form-group col-12" type="submit">
                <a href="/Supplier/storeSUP" class="btn btn-primary">Primary</a>
              </div> -->

                        </div>
                    </div>
                </div>
            </div>
        </form>

    </section>
@endsection
