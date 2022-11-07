@extends('payments.layouts.main')
@section('content')
<section class="section">
  <div class="section-header">
    <h1>Form Data Bahan Baku</h1>
  </div>

  
 
  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="form-group">
            <label>Nama Bahan Baku</label>
            <input type="text" class="form-control">
          </div>
          <div class="form-group">
            <label>Stok</label>
            <input type="text" class="form-control">
          </div>
          <div class="form-group">
            <label>Harga Satuan</label>
            <input type="text" class="form-control">
          </div>
          <div class="form-group">
            <label>Supplier</label>
            <select class="form-control">
              <option>-- Pilih Supplier --</option>
              <option>jaya perkasa</option>
              <option>batik wongso</option>
              <option>lestari Homemade</option>
            </select>
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