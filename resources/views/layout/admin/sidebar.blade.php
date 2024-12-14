<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion" aria-label="Side Navigation Menu">
        <div class="sb-sidenav-menu" aria-label="Main Navigation Menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <button class="nav-link collapsed {{ request()->routeIs('laporanpulsa.index', 'laporanpaketdata.index', 'laporanbayartagihan.index', 'laporanservices.index', 'laporanpemesananproduct.index') ? 'active' : '' }}"
                    href="#" data-bs-toggle="collapse" data-bs-target="#collapseLaporan" aria-expanded="false"
                    aria-controls="collapseLaporan" role="button">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Laporan
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </button>
                <div class="collapse {{ request()->routeIs('laporanpulsa.index', 'laporanpaketdata.index', 'laporanbayartagihan.index', 'laporanservices.index', 'laporanpemesananproduct.index') ? 'show' : '' }}"
                    id="collapseLaporan" aria-labelledby="headingLaporan" aria-controls="collapseLaporan">
                    <nav class="sb-sidenav-menu-nested nav" aria-label="Laporan Submenu">
                        <a class="nav-link {{ request()->routeIs('laporanpulsa.index') ? 'active' : '' }}"
                            href="{{ route('laporanpulsa.index') }}">Laporan Pulsa</a>
                        <a class="nav-link {{ request()->routeIs('laporanpaketdata.index') ? 'active' : '' }}"
                            href="{{ route('laporanpaketdata.index') }}">Laporan Paket Data</a>
                        <a class="nav-link {{ request()->routeIs('laporanbayartagihan.index') ? 'active' : '' }}"
                            href="{{ route('laporanbayartagihan.index') }}">Laporan Bayar Tagihan</a>
                        <a class="nav-link {{ request()->routeIs('laporanservices.index') ? 'active' : '' }}"
                            href="{{ route('laporanservices.index') }}">Laporan Service</a>
                        <a class="nav-link {{ request()->routeIs('laporanpemesananproduct.index') ? 'active' : '' }}"
                            href="{{ route('laporanpemesananproduct.index') }}">Laporan Pemesanan Product</a>
                    </nav>
                </div>
                <a class="nav-link collapsed {{ request()->routeIs('pulsa.index', 'paket_data.index', 'bayar_tagihan.index', 'services.index') ? 'active' : '' }}"
                    href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayanan" aria-expanded="false"
                    aria-controls="collapseLayanan" role="button">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Layanan
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ request()->routeIs('pulsa.index', 'paket_data.index', 'bayar_tagihan.index', 'services.index') ? 'show' : '' }}"
                    id="collapseLayanan" aria-labelledby="headingLayanan" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav" aria-label="Layanan Submenu">
                        <a class="nav-link {{ request()->routeIs('pulsa.index') ? 'active' : '' }}"
                            href="{{ route('pulsa.index') }}">Pulsa</a>
                        <a class="nav-link {{ request()->routeIs('paket_data.index') ? 'active' : '' }}"
                            href="{{ route('paket_data.index') }}">Paket Data</a>
                        <a class="nav-link {{ request()->routeIs('bayar_tagihan.index') ? 'active' : '' }}"
                            href="{{ route('bayar_tagihan.index') }}">Bayar Tagihan</a>
                        <a class="nav-link {{ request()->routeIs('services.index') ? 'active' : '' }}"
                            href="{{ route('services.index') }}">Service</a>
                    </nav>
                </div>

                <a class="nav-link {{ request()->routeIs('product.index') ? 'active' : '' }}"
                    href="{{ route('product.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Product
                </a>

            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            {{ auth()?->User }}
        </div>
    </nav>
</div>
