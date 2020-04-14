<header>
    <div class="container">
        <div class="main-menu__top">
            <div class="main-menu__top-item">
                <img class="logo" src="{{ asset('assets/img/logo-cap.png') }}" alt="">
            </div>
            <div class="main-menu__top-item search">
                <form class="form-inline form-general" action="{{ url('/search') }}" method="GET">
                    <input class="form-control " type="search" placeholder='  Buscar productos,  marcas y más'
                        aria-label="Search" name="search">
                    <button class="btn btn-form" type="submit"><img src="{{ asset('assets/img/lupa.svg') }}" alt=""></button>
                </form>
            </div>
            <div class="main-menu__top-item">
                <ul>
                    @if(Auth::check() && Auth::user()->id)
                        <li><a href="#">{{ Auth::user()->name }}</a></li>
                    @else
                        <li><a href="{{ url('/login') }}"><img src="{{ asset('assets/img/persona2.svg') }}" alt=""></a></li>
                    @endif
                    <li><a href=""><img src="{{ asset('assets/img/telefono.svg') }}" alt=""></a></li>
                    @if(Auth::check() && Auth::user()->id)
                        <li><a href="{{ url('/cart') }}"><img src="{{ asset('assets/img/carro2.svg') }}" alt=""></a></li>
                    @endif

                </ul>
            </div>
        </div>
    </div>


    <nav class="navbar navbar-expand-md fixed-top navbar-fixed-js">
        <div class="container">
            <div class="main-brand">
                <button class="navbar-toggler p-2 border-0 hamburger hamburger--elastic" data-toggle="offcanvas" type="button">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
            <div class="navbar-collapse offcanvas-collapse">
                <ul class="navbar-nav m-auto">


                    <li class="nav-item dropdown mega-menu">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                            aria-haspopup="true" aria-expanded="false">Categorías</a>
                        <div class="dropdown-menu" style="opacity: 1;">
                            dfdff
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Marcas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="detalle.html">Ofertas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Impresión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Computación</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Software</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>