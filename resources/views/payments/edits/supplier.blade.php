@extends('gudang.layouts.main')
@section('content')
<section class="section">
  <div class="section-header">
    <h1>Form Data Supplier</h1>
  </div>

  
 
  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="form-group">
            <label>Nama Supplier</label>
            <input type="text" class="form-control">
          </div>
          <div class="form-group">
            <label>Pemilik Supplier</label>
            <input type="text" class="form-control">
          </div>
          <div class="form-group">
            <label>Alamat Supplier</label>
            <input type="text" class="form-control">
          </div>
          <div class="form-group">
            <label>No. Telepon Supplier</label>
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