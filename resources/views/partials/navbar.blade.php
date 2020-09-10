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
                                margin-right: 10px;">   {{ Auth::user()->name }}
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

                    <div class="navbar navbar-expand-md  navbar-hover">
                        <div class="collapse navbar-collapse" id="navbarHover">
                            <ul class="navbar-nav">      
                                <li class="nav-item dropdown ">
                                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-top: -20px;">
                                        Categorías
                                    </a>
                                    <ul class="dropdown-menu dropdown-left  ">
                                     <div>
                                        <div class="hover--grid">

                                            @foreach(App\Category::where('parent_id', null)->whereNotNull("esp_name")->get() as $category)

                                                @if(App\Category::where('parent_id', $category->id)->count() == 0)
                                                    <li  >
                                                        <a class="dropdown-item" href="{{ url('/category/'.$category->slug) }}">{{ $category->esp_name }}</a>
                                                    </li>

                                                    
                                                @else

                                                    <li>
                                                        <a class="dropdown-item dropdown-toggle" href="{{ url('/category/'.$category->slug) }}">{{ $category->esp_name }}</a>
                                                        <ul class="dropdown-menu">
                                                        @foreach(App\Category::where('parent_id', $category->id)->get() as $category)
                                                            <li><a class="dropdown-item" href="{{ url('/category/'.$category->slug) }}">{{ $category->esp_name }}</a></li>
                                                        @endforeach
                                                        </ul>   
                                                    </li>    

                                                @endif

                                                
                                                
                                            @endforeach
                                        </div>
                                     </div>
                               

                                        <!--<li><a class="dropdown-item" href="#">Link</a></li>
                                        <li><a class="dropdown-item" href="#">Link</a></li>
                                        <li><a class="dropdown-item dropdown-toggle" href="#">Submenu</a>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Submenu link</a></li>
                                                <li><a class="dropdown-item" href="#">Submenu link 2</a></li>
                                                <li><a class="dropdown-item dropdown-toggle" href="#">Subsubmenu</a>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="#">Subsubmenu 1</a></li>
                                                        <li><a class="dropdown-item" href="#">Subsubmenu 2</a></li>
                                                    </ul>
                                                </li>
                                                <li><a class="dropdown-item dropdown-toggle" href="#">Subsubmenu 2</a>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="#">Subsubmenu 2.1</a></li>
                                                        <li><a class="dropdown-item" href="#">Subsubmenu 2.2</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>-->
                                     
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                            
                    <li class="nav-item navbar-custom">
                        <a class="nav-link" href="{{ url('/products/destacados') }}">Productos Destacados</a>
                    </li>
                    <li class="nav-item navbar-custom">
                        <a class="nav-link" href="{{ url('/somos') }}">Quiénes somos</a>
                    </li>

                    <li class="nav-item show-on-mobile navbar-custom">
                        <a class="nav-link" href="{{ url('/best/stores') }}">Mejores Tiendas</a>
                    </li>

                    <li class="navbar-expand-md  navbar-hover nav-item">
                        <div class="collapse navbar-collapse m-0" id="navbarHover">
                            <ul class="navbar-nav">      
                               
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                     
                                        Mejores tiendas
                                    </a>
                                    <ul class="dropdown-menu p-3">            
                                        @foreach(App\BestStore::with("brand")->get() as $brand)
                                            <li class="mb-2">
                                                <a href="{{ url('/brand/'.$brand->brand->slug) }}">{{ $brand->brand->name }}</a>
                                            </li>
                                        @endforeach
                                       
                                    </ul>
                                </li>
                          
                            </ul>
                        </div>
                    </li>


                  <!---  <li class="nav-item dropdown mega-menu">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" id="menu-brands">Mejores tiendas</a>
                        <div class="dropdown-menu" style="opacity: 1;" id="menu-brands-dropdown">
                            <div class="grid-menu">
                                <div class="grid-menu__item">
                                    <ul>
                                        @foreach(App\Brand::inRandomOrder()->take(10)->get() as $brand)
                                            <li>
                                                <a href="{{ url('/brand/'.$brand->slug) }}">{{ $brand->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </li>--->
                    <!--<li class="nav-item">
                        <a class="nav-link" href="#">Software</a>
                    </li>-->
                </ul>
            </div>
        </div>
    </nav>
</header>