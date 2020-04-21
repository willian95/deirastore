@extends('layouts.main')

@section('content')

    @include('partials.navbar')

    <div class="container bg">
        <section class="informacion-detalles container">
            <div class="desc">
                <p><strong>30</strong>%<br> DCTO.</p>
            </div>
            <div class="">

                <div class="col-sm-12 banner-productos">
                    <!--<div class="migas"><a href="#">Home </a> > <a href="#"> Computadores </a> > <a href="#">
                            Computadores
                            Portátiles</a> > <a href="#"> Hp </a>
                    </div>-->
                </div>
                <div class="row">
                    <div class="col-sm-6">

                        <div class="div-informacion-detalles">
                            <h2><strong>{{ $product->name }}</strong></h2>
                            <h3 style="">$  @if($product->external_price > 0)
                                                {{ intval($product->external_price * App\DolarPrice::first()->price) }} 
                                            @else
                                                {{ $product->price }}
                                            @endif
                            
                            @if($product->tax_excluded == false)<small style="">IVA incluido.</small> @else <small style="">Excento de IVA.</small> @endif</h3>
                            
                            <h5>{{ $product->sub_title }}</h5>
                            <ul>
                                <li><strong>SKU:</strong> {{ $product->sku }}</li>
                                <li><strong>VPN:</strong> {{ $product->vpn }}</li>
                                <li><strong>STOCK:</strong> {{ $product->amount }}</li>
                            </ul>

                            @if(Auth::check())
                                @if($product->amount > 0)

                                    <div class="container">
                                        <div class="row">
                                            <div class="col-4">
                                                <button class="btn btn-danger" @click="substract()" style="margin-top: 28px"> restar</button>
                                            </div>
                                            <div class="col-4">
                                                <label for="amount">Cantidad</label>
                                                <input type="number" class="form-control" id="amount" v-model="amount" max="{{ $product->amount }}" min="1" readonly>
                                                
                                            </div>
                                            <div class="col-4">
                                                <button class="btn btn-success" @click="add()" style="margin-top: 28px"> sumar</button>
                                            </div>
                                            <div class="col-12">
                                                <button class="btn btn-info" @click="store()">añadir al carrito</button>
                                            </div>
                                        </div>
                                    </div>
                                @else

                                    <p>Producto sin stock</p>

                                @endif
                                <!--<a href="" class="comprar-producto-details">COMPRAR</a>-->
                            @else
                                <p><a href="{{ url('/login') }}">Inicia sesión</a> para poder comprar</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        @if($product->is_external == false)
                            <img class="imagen-detalles" src="{{ asset('/images/products/'.$product->picture) }}" alt="">
                        @else
                            <img class="imagen-detalles" src="{{ $product->picture }}" alt="">
                        @endif
                        <div class="logo-detalle">
                            @if($product->brand->image != null)
                                <img src="{{ asset('/images/brands/'.$product->brand->image) }}" alt="">
                            @endif
                        </div>
                        <!--<div class="imagen-detalles-sub">
                            <img src="{{ asset('assets/img/deira-70.png') }}" alt="">
                            <img src="{{ asset('assets/img/deira-71.png') }}" alt="">
                            <img src="{{ asset('assets/img/deira-72.png') }}" alt="">

                        </div>-->
                    </div>

                </div>
            </div>
        </section>

        <div>
            <div class="beneficios">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="compra-protegida">
                            <div class="row">
                                <div class="col-sm-4">
                                    <img src="{{ asset('assets/img/entrega.svg') }}" alt="">
                                </div>
                                <div class="col-sm-8">
                                    <h3>COMPRA PROTEGIDA</h3>
                                    <h5>Recibe de forma segura </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="medios-pago">
                            <div class="row">
                                <div class="col-sm-4">
                                    <img src="{{ asset('assets/img/entrega.svg') }}" alt="">
                                </div>
                                <div class="col-sm-8">
                                    <h3>MEDIOS DE PAGO</h3>
                                    <h5>Tarjetas débito, crédito</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="despachos">
                            <div class="row">
                                <div class="col-sm-4">
                                    <img src="{{ asset('assets/img/entrega.svg') }}" alt="">
                                </div>
                                <div class="col-sm-8">
                                    <h3>DESPACHOS </h3>
                                    <h5>5 a 10 días hábiles</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <div class="presentacion">
            <div class="row">
                <div class="col-sm-12 ">
                    <div id="accordion">
                        <div class="card">
                            <a class="card-link" data-toggle="collapse" href="#collapseUno">
                                <div class="card-header acordeon">
                                    <h2><strong>Descripción </strong>producto</h2>
                                </div>
                            </a>
                            <div id="collapseUno" class="collapse show" data-parent="#accordion">
                                <div class="card-body">
                                    <p style="    padding: 20px;">{{ $product->description }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <a class="collapsed card-link" data-toggle="collapse" href="#collapseDos">
                                <div class="card-header acordeon-2">
                                    <h2><strong>Especificaciones</strong></h2>
                                </div>
                        </div>
                        </a>
                        <div id="collapseDos" class="collapse" data-parent="#accordion">
                            <div class="card-body">
                                <div class="container">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td>Descripción del producto</td>
                                                <td>{{ $product->min_description }}
                                                </td>
                                            </tr>
                                            @if($product->product_type)
                                            <tr>
                                                <td>Tipo de producto</td>
                                                <td>{{ $product->product_type }}</td>
                                            </tr>
                                            @endif
                                            @if($product->color)
                                            <tr>
                                                <td>Color</td>
                                                <td>{{ $product->color }}</td>
                                            </tr>
                                            @endif
                                            @if($product->product_material)
                                            <tr>
                                                <td>Material del producto</td>
                                                <td>{{ $product->product_material }}</td>
                                            </tr>
                                            @endif
                                            @if($product->dimenssions)
                                            <tr>
                                                <td>Dimensiones</td>
                                                <td>{{ $product->dimenssions }}</td>
                                            </tr>
                                            @endif
                                            @if($product->weight)
                                            <tr>
                                                <td>Peso </td>
                                                <td>{{ $product->weight }}</td>
                                            </tr>
                                            @endif
                                            @if($product->features)
                                            <tr>
                                                <td>Características </td>
                                                <td>{{ $product->features }}</td>
                                            </tr>
                                            @endif
                                            @if($product->location)
                                            <tr>
                                                <td>Localización </td>
                                                <td>{{ $product->location }}</td>
                                            </tr>
                                            @endif
                                            @if($product->warranty)
                                            <tr>
                                                <td>Garantía del fabricante </td>
                                                <td>{{ $product->warranty }}</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <a class="collapsed card-link" data-toggle="collapse" href="#collapseTres">
                            <div class="card-header acordeon-2">
                                <h2><strong>Calificación </strong>y Comentarios</h2>


                            </div>
                    </div>
                    </a>
                    <div id="collapseTres" class="collapse" data-parent="#accordion">
                        <div class="card-body">
                            <div class="container comentarios">
                                <div class="row">
                                    <div class="col-sm-6 comentarios-calificacion">
                                        <h3><strong>Calificación</strong> General</h3>
                                        <h5><strong>Seleccione </strong>una nota para ver sus comentarios</h5>

                                       

                                    </div>
                                    <div class="col-sm-6">
                                        <div class="comentario">
                                            <h3><strong>Roberto</strong></h3>
                                            <h5>12 Febrero 2020</h5>
                                            <p>“Muy buena calidad de resolución y sonido muy flexibles y de buena
                                                calidad ”
                                            </p>
                                        </div>
                                        <div class="comentario">
                                            <h3><strong>María</strong></h3>
                                            <h5>12 Febrero 2020</h5>
                                            <p>“Muy buena calidad de resolución y sonido muy flexibles y de buena
                                                calidad ”
                                            </p>
                                        </div>
                                        <div class="comentario">
                                            <h3><strong>Camilo</strong></h3>
                                            <h5>12 Febrero 2020</h5>
                                            <p>“Muy buena calidad de resolución y sonido muy flexibles y de buena
                                                calidad ”
                                            </p>
                                        </div>
                                     
                                    </div>
                                </div>
                            </div>
                            <div class="line">
                                <a href="" class="agregar-comentario">Agregar Comentario</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- productos relacionados -->

            <section>
                <div class="title__general">
                    <p><strong>Productos </strong>relacionados</p>
                </div>

                <div class="container">
                    <div class="main-slider__content">
                        <div class="main-slider__item">
                            <div class="content-slider">
                                <img src="{{ asset('assets/img/deira-09.png') }}" alt="">
                            </div>
                            <div class="main-slider__text">
                                <span>Pisonee Poner Lite 525W</span>
                                <p class="title">Proyector</p>
                                <span class="price">$ 935.990</span>
                                <p class="price-old">Normal <span>$999.999</span></p>
                            </div>
                        </div>
                        <div class="main-slider__item">
                            <div class="content-slider">
                                <img src="{{ asset('assets/img/deira-10.png') }}" alt="">
                            </div>
                            <div class="main-slider__text">
                                <span>Pisonee Poner Lite 525W</span>
                                <p class="title">Proyector</p>
                                <span class="price">$ 935.990</span>
                                <p class="price-old">Normal <span>$999.999</span></p>
                            </div>
                        </div>
                        <div class="main-slider__item">
                            <div class="content-slider">
                                <img src="{{ asset('assets/img/deira-11.png') }}" alt="">
                            </div>
                            <div class="main-slider__text">
                                <span>Pisonee Poner Lite 525W</span>
                                <p class="title">Proyector</p>
                                <span class="price">$ 935.990</span>
                                <p class="price-old">Normal <span>$999.999</span></p>
                            </div>
                        </div>
                        <div class="main-slider__item">
                            <div class="content-slider">
                                <img src="{{ asset('assets/img/deira-12.png') }}" alt="">
                            </div>
                            <div class="main-slider__text">
                                <span>Pisonee Poner Lite 525W</span>
                                <p class="title">Proyector</p>
                                <span class="price">$ 935.990</span>
                                <p class="price-old">Normal <span>$999.999</span></p>
                            </div>
                        </div>
                        <div class="main-slider__item">
                            <div class="content-slider">
                                <img src="{{ asset('assets/img/deira-13.png') }}" alt="">
                            </div>
                            <div class="main-slider__text">
                                <span>Pisonee Poner Lite 525W</span>
                                <p class="title">Proyector</p>
                                <span class="price">$ 935.990</span>
                                <p class="price-old">Normal <span>$999.999</span></p>
                            </div>
                        </div>




                        <div class="main-slider__item">
                            <div class="content-slider">
                                <img src="{{ asset('assets/img/deira-15.png') }}" alt="">
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
            </section>

        </div>
    </div>

@endsection

@push('scripts')
    
    <script>
            
        const app = new Vue({
            el: '#dev-app',
            data(){
                return{
                    productId:"{!! $product->id !!}",
                    modalTitle: "Añadir al carrito",
                    amount:1,
                    maxAmount:"{!! $product->amount !!}"
                }
            },
            methods:{

                store(){

                    let formData = new FormData()
                    formData.append("productId", this.productId)
                    formData.append("amount", this.amount)

                    axios.post("{{ route('cart.store') }}", formData)
                    .then(res => {

                        if(res.data.success == true){

                            alert(res.data.msg)
                            this.amount = 1;

                        }else{

                            alert(res.data.msg)

                        }

                    })
                    .catch(err => {
                        
                        $.each(err.response.data.errors, function(key, value){
                            alert(value)
                        });

                    })

                },
                add(){

                    if(this.amount + 1 <= this.maxAmount){
                        this.amount++;
                    }

                },
                substract(){

                    if(this.amount - 1 > 0){
                        this.amount--
                    }

                }

            },
            mounted(){
                //this.test()
            }

        })

    </script>

@endpush