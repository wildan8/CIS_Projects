@extends('main')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Form Data Return Bahan Baku</h1>
        </div>



        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="form-group">
                            <label>Nama Bahan Baku</label>
                            <select class="form-control">
                                <option>-- Bahan Baku --</option>
                                <option>kain blue 12255</option>
                                <option>SC 1248dj</option>
                                <option>WB f64533</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Jumlah</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Tanggal Terima</label>
                            <input type="date" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="buttons">
                            <a href="#" class="btn btn-primary">Primary</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
