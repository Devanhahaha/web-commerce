<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading"></div>
                <a class="nav-link {{ request()->routeIs('dashboardcust.index') ? 'active' : '' }}" href="{{ route('dashboardcust.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
            
                <!-- Menu Layanan -->
                <a class="nav-link collapsed {{ request()->routeIs('pulsaCust.index', 'paket_dataCust.index', 'bayar_tagihanCust.index', 'serviceCust.index') ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayanan" aria-expanded="false" aria-controls="collapseLayanan">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Layanan
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ request()->routeIs('pulsaCust.index', 'paket_dataCust.index', 'bayar_tagihanCust.index', 'serviceCust.index') ? 'show' : '' }}" id="collapseLayanan" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ request()->routeIs('pulsaCust.index') ? 'active' : '' }}" href="{{ route('pulsaCust.index') }}">Pulsa</a>
                        <a class="nav-link {{ request()->routeIs('paket_dataCust.index') ? 'active' : '' }}" href="{{ route('paket_dataCust.index') }}">Paket Data</a>
                        <a class="nav-link {{ request()->routeIs('bayar_tagihanCust.index') ? 'active' : '' }}" href="{{ route('bayar_tagihanCust.index') }}">Bayar Tagihan</a>
                        <a class="nav-link {{ request()->routeIs('serviceCust.index') ? 'active' : '' }}" href="{{ route('serviceCust.index') }}">Service</a>
                    </nav>
                </div>
            
                <a class="nav-link {{ request()->routeIs('productCust.index') ? 'active' : '' }}" href="{{ route('productCust.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Product
                </a>
                
                <a class="nav-link {{ request()->routeIs('cart.index') ? 'active' : '' }}" href="{{ route('cart.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                    Keranjang
                </a>
            
                <!-- Menu Riwayat Transaksi -->
                <a class="nav-link collapsed {{ request()->routeIs('riwayatTransaksiPulsa.index', 'riwayatTransaksiPaketData.index', 'riwayatTransaksiBayarTagihan.index', 'riwayatTransaksiProduct.index', 'riwayatTransaksiServices.index') ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseRiwayatTransaksi" aria-expanded="false" aria-controls="collapseRiwayatTransaksi">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Riwayat Transaksi
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ request()->routeIs('riwayatTransaksiPulsa.index', 'riwayatTransaksiPaketData.index', 'riwayatTransaksiBayarTagihan.index', 'riwayatTransaksiProduct.index', 'riwayatTransaksiServices.index') ? 'show' : '' }}" id="collapseRiwayatTransaksi" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ request()->routeIs('riwayatTransaksiPulsa.index') ? 'active' : '' }}" href="{{ route('riwayatTransaksiPulsa.index') }}">Riwayat Transaksi Pulsa</a>
                        <a class="nav-link {{ request()->routeIs('riwayatTransaksiPaketData.index') ? 'active' : '' }}" href="{{ route('riwayatTransaksiPaketData.index') }}">Riwayat Transaksi Paket Data</a>
                        <a class="nav-link {{ request()->routeIs('riwayatTransaksiBayarTagihan.index') ? 'active' : '' }}" href="{{ route('riwayatTransaksiBayarTagihan.index') }}">Riwayat Transaksi Bayar Tagihan</a>
                        <a class="nav-link {{ request()->routeIs('riwayatTransaksiProduct.index') ? 'active' : '' }}" href="{{ route('riwayatTransaksiProduct.index') }}">Riwayat Transaksi Product</a>
                        <a class="nav-link {{ request()->routeIs('riwayatTransaksiServices.index') ? 'active' : '' }}" href="{{ route('riwayatTransaksiServices.index') }}">Riwayat Transaksi Services</a>
                    </nav>
                </div>
                
            </div>
            
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            {{ auth()?->User()->first_name ??'-'}}
        </div>
    </nav>
</div>