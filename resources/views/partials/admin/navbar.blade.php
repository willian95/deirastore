<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Deira's Store</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
  
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            @if(Auth::check() && Auth::user()->id)
                <li class="nav-item active">
                    <a class="nav-link" href="#">{{ Auth::user()->name }}</a>
                </li>
                @if(Auth::user()->rol_id == 1)
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('user.purchase') }}">Mis compras</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('profile') }}">Perfil</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('cart') }}">Cart</a>
                    </li>
                @endif
                @if(Auth::user()->rol_id == 3)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.products') }}">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.brands') }}">Tiendas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.categories') }}">Categorías</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.purchase') }}">Compras</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.sale') }}">Ventas</a>
                    </li>
                @endif
                <li class="nav-item active">
                    <a class="nav-link" href="{{ url('/logout') }}">Cerrar sesión</a>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/register') }}">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/login') }}">Login</a>
                </li>
            @endif
        </ul>
    </div>
</nav>