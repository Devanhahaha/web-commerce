<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion" aria-label="Sidebar Navigation">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <!-- Dashboard -->
                <a class="nav-link {{ request()->routeIs('dashboardcust.index') ? 'active' : '' }}"
                    href="{{ route('dashboardcust.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <!-- Dynamic Menu -->
                @php
                    $menus = [
                        [
                            'title' => 'Layanan',
                            'icon' => 'fas fa-columns',
                            'collapse_id' => 'collapseLayanan',
                            'routes' => [
                                ['name' => 'Pulsa', 'route' => 'pulsaCust.index'],
                                ['name' => 'Paket Data', 'route' => 'paket_dataCust.index'],
                                ['name' => 'Bayar Tagihan', 'route' => 'bayar_tagihanCust.index'],
                                ['name' => 'Service', 'route' => 'serviceCust.index'],
                            ],
                        ],
                        [
                            'title' => 'Riwayat Transaksi',
                            'icon' => 'fas fa-columns',
                            'collapse_id' => 'collapseRiwayatTransaksi',
                            'routes' => [
                                ['name' => 'Riwayat Transaksi Pulsa', 'route' => 'riwayatTransaksiPulsa.index'],
                                [
                                    'name' => 'Riwayat Transaksi Paket Data',
                                    'route' => 'riwayatTransaksiPaketData.index',
                                ],
                                [
                                    'name' => 'Riwayat Transaksi Bayar Tagihan',
                                    'route' => 'riwayatTransaksiBayarTagihan.index',
                                ],
                                ['name' => 'Riwayat Transaksi Product', 'route' => 'riwayatTransaksiProduct.index'],
                                ['name' => 'Riwayat Transaksi Services', 'route' => 'riwayatTransaksiServices.index'],
                            ],
                        ],
                    ];
                @endphp
                @foreach ($menus as $menu)
                    <a class="nav-link collapsed {{ collect($menu['routes'])->pluck('route')->contains(request()->route()->getName())? 'active': '' }}"
                        href="#" data-bs-toggle="collapse" data-bs-target="#{{ $menu['collapse_id'] }}"
                        aria-expanded="false" aria-controls="{{ $menu['collapse_id'] }}">
                        <div class="sb-nav-link-icon"><i class="{{ $menu['icon'] }}"></i></div>
                        {{ $menu['title'] }}
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse {{ collect($menu['routes'])->pluck('route')->contains(request()->route()->getName())? 'show': '' }}"
                        id="{{ $menu['collapse_id'] }}" data-bs-parent="#sidenavAccordion"
                        aria-labelledby="{{ $menu['collapse_id'] }}Label">
                        <nav class="sb-sidenav-menu-nested nav" aria-label="Submenu for {{ $menu['title'] }}">
                            @foreach ($menu['routes'] as $route)
                                <a class="nav-link {{ request()->routeIs($route['route']) ? 'active' : '' }}"
                                    href="{{ route($route['route']) }}">{{ $route['name'] }}</a>
                            @endforeach
                        </nav>
                    </div>
                @endforeach
                <!-- Product -->
                <a class="nav-link {{ request()->routeIs('productCust.index') ? 'active' : '' }}"
                    href="{{ route('productCust.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Product
                </a>
                <!-- Keranjang -->
                <a class="nav-link {{ request()->routeIs('cart.index') ? 'active' : '' }}"
                    href="{{ route('cart.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                    Keranjang
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            {{ auth()?->user()->first_name ?? '-' }}
        </div>
    </nav>
</div>
