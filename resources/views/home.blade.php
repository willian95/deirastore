@extends('layouts.main')

@section('content')

    @include('partials.navbar')

    <div class="container bg">
        <!-- banner -->
        <div class="main-banner">
            <div class="main-banner__img">
                <img src="assets/img/deira-30.png" alt="">
                <div class="main-banner__content">
                    <div class="title">
                        <p><strong>Notebook</strong> hp</p>
                        <p><strong>$578.990</strong> <small> IVA incluido.</small></p>
                        <p class="mt-3 mb-5">240 G6 i3-6006U Ram 4GB <br> Led 14.0" HD W10 Pro</p>
                        <a href="detalle.html" class="btn-general">Ver Producto...</a>
                    </div>
                    <div class="desc">
                        <p><strong>30</strong>%<br> DCTO.</p>
                    </div>
                </div>
            </div>


        </div>

        <!-- banner card-->
        <div class="main-banner__card">
            <div class="main-banner__card-img">
                <img src="assets/img/card1.png" alt="">
                <div class="title">
                    <p><strong>PROYECTORES</strong></p>
                    <span><strong>30%</strong> <br>DCTO.</span>
                </div>
            </div>
            <div class="main-banner__card-img">
                <img src="assets/img/card2.png" alt="">
                <div class="title">
                    <p><strong>IMPRESORAS</strong> HP</p>
                    <span><strong>20% </strong><br>DCTO. </span>

                    <a href="">Comprar</a>
                </div>

            </div>
            <div class="main-banner__card-img">
                <img src="assets/img/card3.png" alt="">
                <div class="title">
                    <p><strong>NOTEBOOK HP</strong></p>
                    <span><strong>20%</strong> <br>DCTO.</span>
                </div>
            </div>
        </div>


        <!-- categorias -->
        <section>
            <div class="title__general">
                <p><strong>Categorías</strong> principales</p>
            </div>

            <div class="container">
                <div class="main-categorias__content">
                    @foreach($categories as $category)
                        <div class="main-categorias__item">
                            <div class="main-categorias-txt">
                                <a href=""> 
                                    <img src="{{ asset('/images/categories/'.$category->image) }}" alt="">
                                    <span>{{ $category->name}}</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- tinedas -->
        <section class="mejores-tiendas">
            <div class="title__general title__general__blue">
                <p><strong>Mejores </strong> Tiendas</p>
            </div>

            <div class="container">
                <div class="main-shop__grid">
                    @foreach($brands as $brand)
                        <div class="main-shop__item">
                            <img src="{{ asset('/images/brands/'.$brand->image) }}" alt="">
                            <p>{{ $brand->name }}</p>
                            <div class="main-shop__card">
                                @foreach(App\Product::where('brand_id', $brand->id)->orderBy('id', 'desc')->limit(3)->get() as $product)
                                    <div class="main-shop__card-item">
                                        <a href="{{ url('/product/'.$product->slug) }}"> <img style="width: 100%;" src="{{ asset('/images/products/'.$product->picture) }}" alt=""></a>
                                    </div>
                                <!--<div class="main-shop__card-item">
                                    <a href=""> <img src="assets/img/deira-12.png" alt=""></a>
                                </div>
                                <div class="main-shop__card-item">
                                    <a href=""> <img src="assets/img/deira-12.png" alt=""></a>
                                </div>-->

                                @endforeach

                            </div>
                            <a href="">Ver tienda</a>
                        </div>

                    @endforeach

                </div>
            </div>
        </section>
        <!-- producto destacado -->
        <section>
            <div class="title__general">
                <p><strong>Productos </strong>Destacados</p>
            </div>

            <div class="container">
                <div class="main-slider__content">
                    @foreach(App\Product::with('category')->get() as $product)
                        <a href="{{ url('/product/'.$product->slug) }}">
                            <div class="main-slider__item">
                                <div class="content-slider">
                                    <img src="{{ asset('/images/products/'.$product->picture) }}" alt="">
                                </div>
                                <div class="main-slider__text">
                                    <span>{{ $product->name }}</span>
                                    <p class="title">{{ $product->category->name }}</p>
                                    <span class="price">$ {{ $product->sub_price }}</span>
                                    <p class="price-old">Normal <span>${{ $product->price }}</span></p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
        <!-- ofertas -->
        <!--<section>
            <div class="title__general">
                <p><strong>Ofertas</strong> Imperdibles </p>
            </div>

            <div class="container">
                <div class="main-slider__content">
                    <div class="main-slider__item">
                        <div class="content-slider">
                            <img src="assets/img/deira-04.png" alt="">
                        </div>
                        <div class="main-slider__text title-blue ">
                            <span>Pisonee Poner Lite 525W</span>
                            <p class="title">Proyector</p>
                            <span class="price">$ 935.990</span>
                            <p class="price-old">Normal <span>$999.999</span></p>
                        </div>
                    </div>
                    <div class="main-slider__item">
                        <div class="content-slider">
                            <img src="assets/img/deira-05.png" alt="">
                        </div>
                        <div class="main-slider__text title-blue ">
                            <span>Pisonee Poner Lite 525W</span>
                            <p class="title">Proyector</p>
                            <span class="price">$ 935.990</span>
                            <p class="price-old">Normal <span>$999.999</span></p>
                        </div>
                    </div>
                    <div class="main-slider__item">
                        <div class="content-slider">
                            <img src="assets/img/deira-06.png" alt="">
                        </div>
                        <div class="main-slider__text title-blue ">
                            <span>Pisonee Poner Lite 525W</span>
                            <p class="title">Proyector</p>
                            <span class="price">$ 935.990</span>
                            <p class="price-old">Normal <span>$999.999</span></p>
                        </div>
                    </div>
                    <div class="main-slider__item">
                        <div class="content-slider ">
                            <img src="assets/img/deira-07.png" alt="">
                        </div>
                        <div class="main-slider__text title-blue ">
                            <span>Pisonee Poner Lite 525W</span>
                            <p class="title">Proyector</p>
                            <span class="price">$ 935.990</span>
                            <p class="price-old">Normal <span>$999.999</span></p>
                        </div>
                    </div>
                    <div class="main-slider__item">
                        <div class="content-slider">
                            <img src="assets/img/deira-08.png" alt="">
                        </div>
                        <div class="main-slider__text title-blue ">
                            <span>Pisonee Poner Lite 525W</span>
                            <p class="title">Proyector</p>
                            <span class="price">$ 935.990</span>
                            <p class="price-old">Normal <span>$999.999</span></p>
                        </div>
                    </div>




                    <div class="main-slider__item">
                        <div class="content-slider ">
                            <img src="assets/img/deira-09.png" alt="">
                        </div>
                        <div class="main-slider__text">
                            <span>Pisonee Poner Lite 525W</span>
                            <p class="title">Proyector</p>
                            <span class="price">$ 935.990</span>
                            <p class="price-old">Normal <span>$999.999</span></p>
                        </div>
                    </div>

                </div>
            </div>
        </section>-->
    </div>

    <footer>
        <div class="main-footer__content container">
            <div class="main-footer__item">
                <img class="logo-footer" src="assets/img/logo-cap.png" alt="">
                <p class="description">Empresa de Servicio, Soporte, Soluciones y Venta de
                    Productos Informáticos, dando respuesta a requerimientos
                    de integración de harreare y software.</p>
                <a class="contact" href=tel:+56226748000><img src="assets/img/telefono.svg" alt="">+56 22 674 8000</a>

                <ul>
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

@endsection