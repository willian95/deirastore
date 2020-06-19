<div class="admin__grid main-admin">
    <div class="admin_nav-top">
        <ul class="navbar-nav ml-auto">
            <div class="navbar-expand-md  navbar-hover ">
                <div class="collapse navbar-collapse" id="navbarHover">
                    <ul class="navbar-nav">      
                        @if(Auth::check() && Auth::user()->id)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user"></i>
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">            
                            <li>
                                <a class="dropdown-item" href="{{ url('/logout') }}">Cerrar sesión</a></li>
                               
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
            <a class='navbar-brand'  href="{{ url('/') }}">
                 <img class="logo" src="{{ asset('assets/img/logo-cap.png') }}" alt="">
               <!-----  <p>Admin</p>--->
           </a>
          <button class='navbar-toggler p-2 border-0 hamburger hamburger--elastic d-none-lg' data-toggle='offcanvas'
            type='button'>
            <span class='hamburger-box'>
            <span class='hamburger-inner'></span>
            </span>
          </button>
          <div class='offcanvas-collapse fil' id='navbarNav' style="overflow-y: auto">
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
                    <li class="nav-item nav-focus mt-5">
                    
                        <a class="nav-link  active  focus__link" href="">    <i class="fa fa-dashboard"></i>Dashboard</a>
                    </li>
                        <li class="nav-item mt-3 nav-focus">
                            <a class="nav-link  focus__link" href="{{ route('admin.products') }}"><i class="fa fa-product-hunt"></i> Productos</a>
                        </li>
                      
                        <li class="nav-item nav-focus">
                            <a class="nav-link   focus__link" href="{{ route('admin.brands') }}"><i class="fa fa-shopping-bag"></i> Tiendas</a>
                        </li>
                        <li class="nav-item nav-focus">
                            <a class="nav-link   focus__link" href="{{ route('admin.banner.index') }}"><i class="fa fa-photo"></i> Banners</a>
                        </li>
                        <li class="nav-item nav-focus">
                            <a class="nav-link focus__link" href="{{ route('admin.categories') }}"><i class="fa fa-tags"></i> Categorías</a>
                        </li>
                        <!--<li class="nav-item nav-focus">
                            <a class="nav-link   focus__link" href="{{ route('admin.purchase') }}"><i class="fa fa-shopping-cart"></i> Compras</a>
                        </li>-->
                        <li class="nav-item nav-focus">
                            <a class="nav-link    focus__link" href="{{ route('admin.sale') }}"><i class="fa fa-dollar"></i> Ventas</a>
                        </li>
                        <li class="nav-item nav-focus">
                            <a class="nav-link focus__link" href="{{ url('/admin/text/index') }}"><i class="fa fa-tags"></i> Textos</a>
                        </li>
                        <li class="nav-item nav-focus">
                            <a class="nav-link focus__link" href="{{ url('/admin/best-store/index') }}"><i class="fa fa-shopping-bag"></i> Mejores Tiendas</a>
                        </li>
                        <li class="nav-item nav-focus">
                            <a class="nav-link focus__link" href="{{ url('/admin/best-category/index') }}"><i class="fa fa-shopping-bag"></i> Categorías principales</a>
                        </li>
                        <li class="nav-item nav-focus">
                            <a class="nav-link focus__link" href="{{ url('/admin/highlighted-product/index') }}"><i class="fa fa-shopping-bag"></i>Productos destacados</a>
                        </li>
                        <li class="nav-item nav-focus">
                            <a class="nav-link focus__link" href="{{ url('/admin/help-center/index') }}"><i class="fa fa-shopping-bag"></i>Centro de ayuda</a>
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