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
                            <input type="hidden" value="{{ $BB->ID_BahanBaku }}" name="IDBB">
                            <div class="form-group">
                                <label>Nama Bahan Baku</label>
                                <input type="text" class="form-control" value="{{ $BB->Nama_BahanBaku }}" name="NamaBB">
                            </div>
                            <div class="form-group">
                                <label>Stok</label>
                                <input type="text" class="form-control" value="{{ $BB->Stok_BahanBaku }}" name="StokBB">
                            </div>
                            <div class="form-group">
                                <label>Harga Satuan</label>
                                <input type="text" class="form-control" value="{{ $BB->Harga_Satuan }} "
                                    name="HargaSatuanBB">
                            </div>
                            <div class="form-group">
                                <label>Supplier</label>
                                <select class="form-control" name="SupplierID" id="SupplierID">
                                    <option disabled value>-- Pilih Supplier --</option>
                                    @foreach ($sup as $s)
                                        <option value="{{ $s->ID_Supplier }}"
                                            @if ($s->ID_Supplier == $BB->SupplierID || $s->ID_Supplier == $BB->SupplierID) selected @endif>{{ $s->Nama_Supplier }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group row mb-4">
                                <div class="col-sm-12 col-md-9 offset-md-3">
                                    <button href="/Bahanbaku/perbaru" type="submit" class="btn btn-primary">save
                                        data</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </form>

    </section>
@endsection
