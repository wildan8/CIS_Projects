@extends('Register.main')
@section('content')
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="login-brand">
                            <img src="../assets/img/stisla-fill.svg" alt="logo" width="100"
                                class="shadow-light rounded-circle">
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Register</h4>
                            </div>

                            <div class="card-body">
                                <form method="POST" action="/Register">
                                    @csrf
                                    <div class="form-group">
                                        <label for="ID_Karyawan">ID Karyawan</label>
                                        <input id="ID_Karyawan" type="text"
                                            class="form-control @error('ID_Karyawan') is-invalid @enderror"
                                            name="ID_Karyawan" value="{{ old('ID_Karyawan') }}" required autofocus>
                                        @error('ID_Karyawan')
                                            <div class="invalid-feedback">
                                                Isi Dengan Nomor ID Karyawan Anda.
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group ">
                                        <label for="Nama_Karyawan">Nama Karyawan</label>
                                        <input id="Nama_Karyawan" type="text"
                                            class="form-control @error('Nama_Karyawan') is-invalid @enderror"
                                            name="Nama_Karyawan" value="{{ old('Nama_Karyawan') }}" required autofocus>
                                        @error('Nama_Karyawan')
                                            <div class="invalid-feedback">
                                                Isi Dengan Nama Karyawan Anda.
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group ">
                                        <label>Bagian</label>
                                        <select name='Bagian_Karyawan'
                                            class="form-control selectric @error('Bagian_Karyawan') is-invalid @enderror">
                                            <option disabled value>-- Pilih Bagian --</option>
                                            <option value="Gudang"> Gudang </option>
                                            <option value="Admin"> Admin </option>
                                            <option value="Produksi"> Produksi </option>
                                            <option value="Purchasing">Purchasing </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="d-block">Password</label>
                                        <input id="password" type="password"
                                            class="form-control pwstrength @error('password') is-invalid @enderror"
                                            data-indicator="pwindicator" name="password" value="{{ old('password') }}"
                                            required>
                                        @error('password')
                                            <div class="invalid-feedback">
                                                Password Berisi Minimal 5 karakter.
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                                            Daftar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="simple-footer">
                            Copyright &copy; Stisla 2018
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
