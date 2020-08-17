<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Deira store | Productos Informáticos \</title>
    <meta name="description" content="Compra online tecnología, informática ,Amplia variedad de productos descubre las mejores marcas del mercado tecnológico" />
    <meta content='Computación, ventas, ecommerce,informatica,DeiraTic,Deira, DeiraStore,DeiraStore Venta de Productos Informáticos ,Santiago, Chile ' property='og:description'>
    <meta name="robots" content="index, follow">
    <meta name="dc.language" content="es">
    <meta name="dc.source" content="url del sitio">
    <meta itemprop="url" content="url temporal del sitio">
    <meta name="keywords" content="informática ,usb,disco duro,Productos Informáticos, memorias ram, ADATA , 3nstar, Aoc , Sophos,ram ddr2,comprar memoria ram, disco duro ">
    <meta content='iso' property='og:image'>
    <meta property="og:locale" content="es_ES" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Deira" />
    <meta property="og:description" content="La mejor tienda de productos electrónicos" />
    <meta http-equiv="cache-control" content="no-cache" />
    <!---links----->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/slick.css') }}" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" rel="stylesheet" />
    <link href="{{ asset('assets/css/slick-theme.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet" />

    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/admin.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" />
    <link href="{{ asset('alertify/css/alertify.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('alertify/css/themes/bootstrap.min.css') }}" rel="stylesheet" />
    {!! ReCaptcha::htmlScriptTagJsApi() !!}

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-173437279-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-173437279-1');
    </script>

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
        const search = new Vue({
            el: '#search-area',
            data() {
                return {
                    searchText: ""
                }
            },
            methods: {

                search() {

                    if (this.searchText != "") {
                        localStorage.setItem("search", this.searchText)
                        window.location.href = "{{ url('/search') }}"
                    }

                }

            }

        })

        const searchMobile = new Vue({
            el: '#search-area-mobile',
            data() {
                return {
                    searchText: ""
                }
            },
            methods: {

                search() {

                    if (this.searchText != "") {
                        localStorage.setItem("search", this.searchText)
                        window.location.href = "{{ url('/search') }}"
                    }

                }

            }

        })
    </script>

    <script>
        alertify.set('notifier', 'position', 'top-right');
        (function($) {
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

            $("#menu-categories").on("click", function() {
                if ($("#menu-categories-dropdown").hasClass('show')) {
                    $("#menu-categories-dropdown").removeClass('show')
                } else {
                    $("#menu-categories-dropdown").addClass('show')
                }
            })

            $("#menu-brands").on("click", function() {
                if ($("#menu-brands-dropdown").hasClass('show')) {
                    $("#menu-brands-dropdown").removeClass('show')
                } else {
                    $("#menu-brands-dropdown").addClass('show')
                }
            })

        });
    </script>

    @stack('scripts')
</body>



</html>