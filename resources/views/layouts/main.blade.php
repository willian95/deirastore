<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
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

    </head>
    <body>

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
        
        @stack('scripts')
    </body>

    

</html>