<div>
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('homepage.index') }}">E-Commerce</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('homepage.index') ? 'active' : '' }}" aria-current="page" href="{{ route('homepage.index') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('homepage.products') ? 'active' : '' }}" href="{{ route('homepage.products') }}">Products</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('homepage.categories') || request()->routeIs('homepage.category.detail') ? 'active' : '' }}"
                           href="{{ route('homepage.categories') }}" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            Categories
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Kategori Pria (Contoh)</a></li>
                            <li><a class="dropdown-item" href="#">Kategori Wanita (Contoh)</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('homepage.categories') }}">Semua Kategori</a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                    <li class="nav-item me-2">
                        <form class="d-flex" role="search" action="{{ route('homepage.products') }}" method="GET">
                            <input class="form-control form-control-sm me-2" type="search" name="search" placeholder="Cari produk..." aria-label="Search" value="{{ request('search') }}">
                            <button class="btn btn-outline-success btn-sm" type="submit">Cari</button>
                        </form>
                    </li>

                    @if (Auth::guard('customer')->check())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::guard('customer')->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if(Route::has('customer.dashboard'))
                                    <li><a class="dropdown-item" href="{{ route('customer.dashboard') }}">Dashboard</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                <li>
                                    <form method="POST" action="{{ route('customer.logout') }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        {{-- MODIFIKASI DI SINI --}}
                        <li class="nav-item">
                            <a class="btn btn-outline-primary btn-sm me-2" href="{{ route('customer.login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary btn-sm" href="{{ route('customer.register') }}">Register</a>
                        </li>
                        {{-- AKHIR MODIFIKASI --}}
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</div>