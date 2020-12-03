<header>
    <div class="container">
        <div class="main-menu__top">
            <div class="main-menu__top-item">
                <a href="{{ url('/') }}">
                    <img class="logo" src="{{ asset('assets/img/logo-cap.png') }}" alt="">
                </a>
            </div>
            <div class="main-menu__top-item search" id="search-area">
                <form class="form-inline form-general" v-on:submit.prevent="search()">
                    <input class="form-control " v-model="searchText" type="search" placeholder='  Buscar productos,  marcas y más' aria-label="Search" name="search">
                    <button @click="search()" class="btn btn-form" type="button"><img src="{{ asset('assets/img/lupa.svg') }}" alt=""></button>
                </form>
            </div>
            <div class="main-menu__top-item table_nav">
                <ul>                  
                    <li class="nav-item dropdown arrow  btn__user">
                        @if(\Auth::check() && \Auth::user()->id)
                            <a class="nav-link dropdown-toggle user_content"  href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ asset('assets/img/persona2.svg') }}" alt="" style="    width: 20px;
                                margin-right: 10px;">   {{ substr(Auth::user()->name, 0, 10) }} @if(strlen(Auth::user()->name) > 10).@endif
                                <div class="active_user">
                                    
                                </div>
                            </a>
                        @else
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ asset('assets/img/persona2.svg') }}" alt="">
                            </a>    
                        @endif
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @if(Auth::check() && Auth::user()->id)
                                @if(Auth::user()->rol_id == 3)
                                    <a href="{{ url('/admin/dashboard') }}" class="drow-none">Administrador</a>
                                @endif
                                @if(Auth::user()->rol_id == 1)
                                    <a href="{{ url('/profile') }}" class="drow-none">Mis Datos</a>
                                    <a href="{{ url('/wishlist') }}" class="drow-none">Wishlist</a>
                                @endif
                                <a href="{{ url('/logout') }}" class="drow-none">Cerrar sesión</a>
                            @else
                                <a class="drow-none" href="{{ url('/login') }}">Iniciar sesión</a>
                                <a class="drow-none" href="{{ url('/register') }}">Registrarme</a>
                            @endif
                        </div>
                    </li>

                    <!--<li><a href=""><img src="{{ asset('assets/img/telefono.svg') }}" alt=""></a></li>-->
                    
                    <li><a class="cart__btn" href="{{ url('/cart') }}"><img src="{{ asset('assets/img/carro2.svg') }}" alt=""><span id="total"></span></a></li>
                    
                        <script>
                            
                            window.setInterval(function(){
                               
                                var total = 0;
                                cart = null

                                if(window.localStorage.getItem('cart') != null){
                                    cart =JSON.parse(window.localStorage.getItem('cart'))
                                }
                                //console.log(cart)
                                if(cart != null && cart.length > 0){
                                    cart.forEach((data, index)=>{
                                        //console.log("i'm here", total, data.amount + total)
                                        //total 
                                        //total = parseInt(total) + parseInt(this.amount)
                                        total = total + data.amount
                                        
                                    })
                                }
                                
                                //console.log("i'm here2", total)
                                $("#total").html(total)

                            }, 5000)
                        
                        </script>
                    
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

                    <li class="nav-item navbar-custom hidden-md-up"   id="search-area-mobile">
                        <input type="text" id="search" class="form-control" v-model="searchText" placeholder="Buscar" v-on:keyup.enter="search()">
                    </li>

                    <li class="nav-item navbar-custom">
                        <a class="nav-link" href="{{ route('brands.all') }}">Marcas </a>
                    </li>

                      
                    <li class="nav-item navbar-custom show-on-mobile">
                        <a class="nav-link" href="{{ url('/categories') }}">
                            Categorías
                        </a>
                    </li>
   
                    <li class="dropdown" id="categorias-dropdown">
                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> <span class="nav-label">Categorías</span> <span class="caret"></span></a>
                        <ul class="dropdown-menu" style="width: 240px; padding-left: 10px; padding-right: 10px;">

                            @foreach(App\Category::where('parent_id', null)->whereNotNull("esp_name")->get() as $category)

                                <li class="dropdown-submenu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <span class="nav-label">{{ $category->esp_name }}</span><span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        @foreach(App\Category::where('parent_id', $category->id)->get() as $category)
                                            <li><a class="dropdown-item" href="{{ url('/category/'.$category->slug) }}">{{ $category->esp_name }}</a></li>
                                        @endforeach
                                    </ul>   
                                </li>    

                            @endforeach

                            
                        </ul>
                    </li>
                            
                            
                    <li class="nav-item navbar-custom">
                        <a class="nav-link" href="{{ url('/products/destacados') }}">Productos Destacados</a>
                    </li>
                    <li class="nav-item navbar-custom">
                        <a class="nav-link" href="{{ url('/somos') }}">Quiénes somos</a>
                    </li>

                    <li class="nav-item show-on-mobile navbar-custom">
                        <a class="nav-link" href="{{ url('/best/stores') }}">Mejores Tiendas</a>
                    </li>

                    <li class="dropdown" id="categorias-dropdown">
                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> <span class="nav-label">MejoresTiendas</span> <span class="caret"></span></a>
                        <ul class="dropdown-menu" style="padding-left: 10px; padding-right: 10px;">

                            @foreach(App\BestStore::with("brand")->get() as $brand)

                                <li class="dropdown-item">
                                    <a href="{{ url('/brand/'.$brand->brand->slug) }}" > 
                                    {{ $brand->brand->name }}</a>  
                                </li>    

                            @endforeach

                            
                        </ul>
                    </li>
                    

                </ul>
            </div>
        </div>
    </nav>
</header>
