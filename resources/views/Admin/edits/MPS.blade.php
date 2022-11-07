@extends('Admin.layouts.main')
@section('content')
<section class="section">
  <div class="section-header">
    <h1>Form Data MPS</h1>
  </div>

  
 
  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="form-group">
            <label>Nama Produk</label>
            <select class="form-control">
              <option>-- Produk --</option>
              <option>Kemeja Hawaiian style</option>
              <option>Short Pants</option>
              <option>WB f64533</option>
            </select>
          </div>
          <div class="form-group">
            <label>Jumlah</label>
            <input type="text" class="form-control">
          </div>
          <div class="form-group">
            <label>tanggal</label>
            <input type="date" class="form-control">
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