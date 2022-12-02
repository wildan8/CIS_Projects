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
            @if(Auth::user()->Bagian_Karyawan== "Gudang")

            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="/Gudang">Permintaan Bahan Baku</a></li>
                    <li><a class="nav-link" href="/GudangPer">Laporan Pesanan</a></li>
                </ul>
            </li>
            @elseif(Auth::user()->Bagian_Karyawan== "Produksi")
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="/Produksi" class="nav-link "><span>Kebutuhan Produksi</span></a>
                    </li>
                    <li><a class="nav-link" href="/ProduksiDone">Laporan Produksi</a></li>
                </ul>
            </li>
            @elseif(Auth::user()->Bagian_Karyawan== "Admin")
            <li class="nav-item ">
                <a href="/Admin" class="nav-link "><span>Dashboard MRP</span></a>
            </li>
            @elseif(Auth::user()->Bagian_Karyawan== "Payment")
            <li class="nav-item ">
                <a href="/Payment" class="nav-link "><span>Dashboard Payment</span></a>

            </li>
            @endif
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
            <li class="active"><a class="nav-link" href="/MRP"><i class="far fa-square"></i> <span>Hitung MRP</span></a></li>
            <!-- Sidebar Admin End -->

            @elseif(Auth::user()->Bagian_Karyawan== "Payment")
            <!-- Sidebar Payment Start -->
            <li class="{{ (request()->is('/Payment')) ? 'active' : '' }}"><a class="nav-link" href="/Payment/PaymentProcess"><i class="far fa-square"></i> <span>Payment Process</span></a></li>
            <!-- Sidebar Payment End -->
            @endif
            @endif



    </aside>
</div>
