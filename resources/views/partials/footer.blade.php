<footer>
        <div class="main-footer__content container">
            <div class="main-footer__item">
                <img class="logo-footer" src="assets/img/logo-cap.png" alt="">
                <p class="description">Empresa de Servicio, Soporte, Soluciones y Venta de
                    Productos Informáticos, dando respuesta a requerimientos
                    de integración de harreare y software.</p>
                <a class="contact" href=tel:+56226748000><img src="assets/img/telefono.svg" alt="">+56 22 674 8000</a>

                <ul class="social">
                    <li><a href=""><img src="assets/img/deira-74.png" alt=""></a></li>
                    <li><a href=""><img src="assets/img/deira-76.png" alt=""></a></li>
                </ul>
            </div>
            <div class="main-footer__item">
                <div class="menu-grid">
                    <ul>
                        <p class="title">DEIRA STORE</p>
                        <li><a href="#">Categorías</a></li>
                        <li><a href="#">Productos Destacados</a></li>
                        <li><a href="#">Ofertas Imperdibles</a></li>
                        <li><a href="#">Impresión</a></li>
                        <li><a href="#">Software</a></li>
                    </ul>
                    <ul>
                        <p class="title">SERVICIO AL CLIENTE</p>
                        <li><a href="#">Centro de ayuda</a></li>
                        <li><a href="#">¿Por qué comprar en Deira Store?</a></li>
                        <li><a href="#">Métodos y costos de envío</a></li>
                        <li><a href="#">Seguimiento de mi orden</a></li>
                        <li><a href="#">Cambios y devoluciones</a></li>
                        <li><a href="#">Términos y condiciones</a></li>
               

                    </ul>
                </div>
            </div>
            <div class="main-footer__item">
                <div class="logo-grid">
                  <img width="300px;" src="assets/img/deira-78.png" alt="">
                </div>
            </div>
        </div>
    </footer>

    <script src="">

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