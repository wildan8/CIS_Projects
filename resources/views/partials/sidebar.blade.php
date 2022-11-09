<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Panel CIS</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">CIS</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="nav-item ">
                <a href="#" class="nav-link "><span>Dashboard</span></a>

            </li>
            <li class="menu-header">Data Master</li>

            @if(Auth::check())

            @if(Auth::user()->Bagian_Karyawan== "Gudang")
            <!-- Sidebar Gudang Start -->
            <li class="{{ (request()->is('/Supplier')) ? 'active' : '' }}"><a class="nav-link" href="/Supplier"><i class="far fa-square"></i>
                    <span>Supplier</span></a></li>
            <li class="{{ (request()->is('/BahanBaku')) ? 'active' : '' }}"><a class="nav-link" href="/Bahanbaku"><i class="far fa-square"></i> <span>Bahan
                        Baku</span></a></li>
            <li class="{{ (request()->is('/LOG')) ? 'active' : '' }}"><a class="nav-link" href="/LOG"><i class="far fa-square"></i> <span>LOG Bahan
                        Baku</span></a></li>
            <li class="{{ (request()->is('/ReturnProduk')) ? 'active' : '' }}"><a class="nav-link" href="/ReturnProduk"><i class="far fa-square"></i> <span>Return Bahan
                        Baku</span></a></li>
            <!-- Sidebar Gudang End -->
            @elseif(Auth::user()->Bagian_Karyawan== "Produksi")
            <!-- Sidebar Produksi Start -->
            <li class="{{ (request()->is('/Produksi/produk')) ? 'active' : '' }}"><a class="nav-link" href="/produk"><i class="far fa-square"></i> <span>Master
                        Produk</span></a></li>
            <li class="{{ (request()->is('/Produksi/BOM')) ? 'active' : '' }}"><a class="nav-link" href="/BOM"><i class="far fa-square"></i> <span>Master
                        BOM</span></a></li>
            <!-- Sidebar Gudang End -->
            @elseif(Auth::user()->Bagian_Karyawan== "Admin")
            <!-- Sidebar Admin Start -->
            <li class="{{ (request()->is('/Admin/MPS')) ? 'active' : '' }}"><a class="nav-link" href="/MPS"><i class="far fa-square"></i> <span>Master
                        MPS</span></a></li>
            <li class="active"><a class="nav-link" href="#"><i class="far fa-square"></i> <span>Akun
                        Pegawai</span></a></li>
            <!-- Sidebar Admin End -->
            @endif
            @endif



    </aside>
</div>
