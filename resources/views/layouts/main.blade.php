<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <meta name='description', content='Descripcion del sitio'>
        <meta name='keywords', content='La mejor tienda de productos electrónicos, '>
        <meta name="robots" content="index, follow">
        <meta name="dc.language" content="es">
        <meta name="dc.source" content="url del sitio">
        <meta itemprop="url" content="url temporal del sitio">
        <meta content='descripcion' property='og:description'>
        <meta content='iso' property='og:image'>
        <meta property="og:site_name" content="">
        <meta property="og:title" content="">
        <meta property="og:type" content="">
        <meta property="og:image" content=""> 
        <meta property="og:locale" content="es_ES" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="Deira" />
        <meta property="og:description" content="La mejor tienda de productos electrónicos" />


        <title>Deira</title>
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/css/slick.css') }}" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" rel="stylesheet" />
        <link href="{{ asset('assets/css/slick-theme.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/css/font-awesome.css') }}" rel="stylesheet" />
     
        <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/css/admin.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" />
        <link href="{{ asset('alertify/css/alertify.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('alertify/css/themes/bootstrap.min.css') }}" rel="stylesheet" />
        {!! ReCaptcha::htmlScriptTagJsApi() !!}

    </head>
    <body>

        @include('partials.navbar')
        <div id="dev-app">
            @yield('content')
        </div>
        
        <script src="{{ asset('assets/js/jquery.min.js ') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/blazy/1.8.2/blazy.min.js"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/slick.min.js') }}"></script>
        <script src="{{ asset('assets/js/setting-slick.js') }}"></script>
        <script src="{{ asset('assets/js/main.js') }}"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="{{ asset('alertify/alertify.min.js') }}"></script>
        <script src="{{ asset('/js/app.js') }}"></script>

        <script>
            alertify.set('notifier','position', 'top-right');
            (function($){
                $('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
                if (!$(this).next().hasClass('show')) {
                    $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
                }
                var $subMenu = $(this).next(".dropdown-menu");
                $subMenu.toggleClass('show');

                $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
                    $('.dropdown-submenu .show').removeClass("show");
                });

                return false;
                });
            })(jQuery)
        </script>

        <script>
            new WOW().init();


            $(document).ready(function() {
                $(".megamenu").on("click", function(e) {
                    e.stopPropagation();
                });

                $("#menu-categories").on("click", function(){
                    if($("#menu-categories-dropdown").hasClass('show')){
                        $("#menu-categories-dropdown").removeClass('show')
                    }else{
                        $("#menu-categories-dropdown").addClass('show')
                    }
                })

                $("#menu-brands").on("click", function(){
                    if($("#menu-brands-dropdown").hasClass('show')){
                        $("#menu-brands-dropdown").removeClass('show')
                    }else{
                        $("#menu-brands-dropdown").addClass('show')
                    }
                })

            });
            
        </script>

        <script>
            const app2 = new Vue({
                el: '#mega-menu',
                data(){
                    return{
                        categories:null,
                        page:1,
                        maxPages:0,
                        loading:false
                    }
                },
                methods:{
                    
                    getItems(){
                        this.loading = true
                        axios.get("{{ url('/categories/menu') }}"+"/"+this.page)
                        .then(res => {
                            //console.log(res)
                            this.loading = false
                            if(res.data.success == true){
                                if(this.categories == null){
                                    this.categories = res.data.categories
                                    
                                }else{
                                    res.data.categories.forEach((data, index) => {
                                        this.categories.push(data)
                                    })
                                }

                                this.maxPages = Math.ceil(res.data.categoriesCount/25)
    
                            }else{

                                alertify.error(res.data.msg)

                            }

                        })
                        .catch(err => {
                            this.loading = false
                            alertify.error("Error en el servidor")
                            //console.log(err.response.data)
                        })
                    },
                    moreItems(){
                        this.page ++;
                        this.getItems()
                    }

                },
                mounted(){
                    
                    //this.getItems()

                }

            })
        </script>
        
        @stack('scripts')
    </body>

    

</html>