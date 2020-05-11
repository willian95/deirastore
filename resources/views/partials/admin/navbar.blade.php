<div class="admin__grid main-admin">
    <div class="admin_nav-top">
        <a class='navbar-brand'  href="{{ url('/') }}">
                   <!-----  <img class="logo" src="{{ asset('assets/img/logo-cap.png') }}" alt="">--->
                   <p>Admin</p>
        </a>
        <ul class="navbar-nav ml-auto">
            <div class="navbar-expand-md  navbar-hover ">
                <div class="collapse navbar-collapse" id="navbarHover">
                    <ul class="navbar-nav">      
                        @if(Auth::check() && Auth::user()->id)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">            
                            <li><a class="dropdown-item" href="{{ url('/logout') }}">Cerrar sesión</a></li>
                               
                            </ul>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
          
         
        </ul>
     </div>

     <!---top main---->
    <nav class='navbar navbar-expand-md navbar-fixed-js admin-nav'>
        <div class='fixed__content'>
       
          <button class='navbar-toggler p-2 border-0 hamburger hamburger--elastic d-none-lg' data-toggle='offcanvas'
            type='button'>
            <span class='hamburger-box'>
            <span class='hamburger-inner'></span>
            </span>
          </button>
          <div class='offcanvas-collapse fil' id='navbarNav'>
            <ul class="navbar-nav mr-auto">
                @if(Auth::check() && Auth::user()->id)
                       <!-----   <li class="nav-item active">
                        <a class="nav-link" href="#">{{ Auth::user()->name }}</a>
                    </li>---->
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
                        <a class="nav-link" href="">Dashboard</a>
                    </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.products') }}">Productos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.brands') }}">Tiendas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.banner.index') }}">Banners</a>
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
                  <!-----  <li class="nav-item active">
                        <a class="nav-link" href="{{ url('/logout') }}">Cerrar sesión</a>
                    </li>---->
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
        </div>
    </nav>
</div>