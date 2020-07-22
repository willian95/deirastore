<footer>
        <div class="main-footer__content container">
            <div class="main-footer__item">
                <img class="logo-footer" src="{{ asset('assets/img/logo-cap.png') }}" alt="">
                <p class="description">Empresa de Servicio, Soporte, Soluciones y Venta de
                    Productos Informáticos, dando respuesta a requerimientos
                    de integración de hardware y software.</p>
                    <a class="contact mr-4"  href="mailto:contacto@deira-it.com"> <i class="fa fa-envelope"></i>contacto@deirastore.cl</a>
                <a class="contact" href=tel:+56226748000><img src="{{ asset('assets/img/telefono.svg') }}" alt="">+562 2674 8059</a>

                <ul class="social">
                    <li><a href=""><img src="{{ asset('assets/img/deira-74.png') }}" alt=""></a></li>
                    <li><a href=""><img src="{{ asset('assets/img/deira-76.png') }}" alt=""></a></li>
                </ul>
            </div>
            <div class="main-footer__item">
                <div class="menu-grid">
                    <ul>
                        <p class="title">DEIRA STORE</p>
                        <li><a href="{{ url('/brands/all') }}">Marcas</a></li>
                        <li><a href="{{ url('/categories') }}">Categorías</a></li>
                        <li><a href="{{ url('/best/stores') }}">Mejores Tiendas</a></li>
                        <li><a href="{{ url('/products/destacados') }}">Productos Destacados</a></li>
                        <li><a href="{{ url('/somos') }}">Quienes somos</a></li>
                    </ul>
                    <ul>
                        <p class="title">SERVICIO AL CLIENTE</p>
                        <li><a href="{{ url('/ayuda') }}">Centro de ayuda</a></li>
                        <!--<li><a href="#">¿Por qué comprar en Deira Store?</a></li>
                        <li><a href="#">Métodos y costos de envío</a></li>
                        <li><a href="#">Seguimiento de mi orden</a></li>
                        <li><a href="#">Cambios y devoluciones</a></li>-->
                        <li><a href="{{ url('terms') }}">Términos y condiciones</a></li>

                    </ul>
                </div>
            </div>
            <div class="main-footer__item">
                <div class="logo-grid">
                  <img width="300px;" src="{{asset('assets/img/deira-78.png') }}" alt="">
                </div>
            </div>
        </div>
    </footer>