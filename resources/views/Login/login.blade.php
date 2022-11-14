@extends('Login.main')
@section('content')
<div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                    <div class="login-brand">
                        <img src="../assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle">
                    </div>
                    @if (session()->has('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    @if (session()->has('LoginError'))
                    <div class="alert alert-danger">
                        {{ session('LoginError') }}
                    </div>
                    @endif
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Login</h4>
                        </div>

                        <div class="card-body">
                            <form method="POST" action="/Login">
                                @csrf
                                <div class="form-group">
                                    <label for="ID_Karyawan">Nomor Karyawan</label>
                                    <input id="ID_Karyawan" type="ID_Karyawan" class="form-control  @error('ID_Karyawan') is-invalid @enderror" name="ID_Karyawan" tabindex="1" value="{{ old('ID_Karyawan') }}" required autofocus>
                                    @error('ID_Karyawan')
                                    <div class="invalid-feedback">
                                        Isi dengan Nomor Karyawan Anda.
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="d-block">
                                        <label for="password" class="control-label">Password</label>

                                    </div>
                                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                                    @error('ID_Karyawan')
                                    <div class="invalid-feedback">
                                        Isi Dengan Password Anda.
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                        Login
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
    </section>
</div>
@endsection
