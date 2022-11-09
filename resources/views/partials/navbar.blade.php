<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>

    </form>
    <ul class="navbar-nav navbar-right">

        <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="../assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
                @auth
                <div class="d-sm-none d-lg-inline-block">Hi,
                    {{ auth()->user()->Nama_Karyawan . ' ( ' . auth()->user()->Bagian_Karyawan . ' )' }}</div>
            </a>
            @endauth
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-divider"></div>
                <form action="/Logout" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item has-icon text-danger">
                        Keluar Akun
                    </button>
                </form>
                <div class="dropdown-divider"></div>
            </div>
        </li>
    </ul>
</nav>
