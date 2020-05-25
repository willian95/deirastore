@extends('layouts.main')

@section('content')

    <div class="container bg">
        <div id="product-detail">
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
                        <div class="col-12">
                            <a class="btn btn-primary btn-general btn-general--form" style="color: #fff;" href="{{ url()->previous() }}"><i class="fa fa-arrow-left"></i></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">

                            <div class="div-informacion-detalles">
                                <h2><strong>{{ $product->name }}</strong></h2>
                                <h3>$  @if($product->external_price > 0)
                                                    {{ number_format(intval($product->external_price * App\DolarPrice::first()->price), 0, ",", ".") }} 
                                                @else
                                                    {{ number_format($product->price, 0, ",", ".") }}
                                                @endif
                                
                                @if($product->tax_excluded == false)<small>IVA incluido.</small> @else <small>Excento de IVA.</small> @endif</h3>
                                
                                <h5>{{ $product->sub_title }}</h5>
                                <ul>
                                    <li><strong>SKU:</strong> {{ $product->sku }}</li>
                                    <li><strong>VPN:</strong> {{ $product->vpn }}</li>
                                    <li><strong>STOCK:</strong> {{ $product->amount }}</li>
                                </ul>


                                @if($product->amount > 0)
                                    <div class="container">
                                        <label for="amount" style="margin-left: -10px;">Cantidad</label>   
                                        <div class="row">
                                            
                                        <div class="amout">
                                            <div class="amount_item">  
                                                                            
                                                    <button class="btn btn-cart" @click="substract()" > -</button>                                                                                       
                                            </div>
                                                                            
                                            <div class="amount_item">                                                                                  
                                                
                                                <input type="number" class="form-control btn-cart" id="amount" v-model="amount" max="{{ $product->amount }}" min="1" readonly>                                                                                         
                                            </div>                                                                     
                                            <div class="amount_item">                                                                               
                                                    <button class="btn btn-cart" @click="add()" > +</button>                                      
                                            </div>
                                            <div class="amount_item ml-5">   
                                                                                                                
                                                <button class="btn btn-info" @click="store()">añadir al carrito</button>                                     
                                            </div>
                                        </div>
                                        
                                        <!--  <div class="col-12">
                                                <button class="btn btn-info" @click="store()">añadir al carrito</button>
                                            </div>-->
                                        </div>
                                    </div>
                                @else

                                    <p>Producto sin stock</p>

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
                                    <img class="style-marcas" src="{{ asset('/images/brands/'.$product->brand->image) }}" alt="">
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
                            @if($product->items)
                            <div id="collapseDos" class="collapse" data-parent="#accordion" >
                                <div class="card-body">
                                    <div class="container">
                                        <table class="table table-bordered">
                                            <tbody>
                                                @foreach($product->items as $item)
                                                <tr >
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->description }}
                                                    </td>
                                                </tr>
                                                @endforeach
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div id="collapseDos" class="collapse" data-parent="#accordion" v-else>
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
                            @endif

                        </div>

                        <!--<div class="card">
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
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
            <!-- productos relacionados -->

            <section>
                <div class="title__general fadeInUp wow animated">
                    <p><strong>Productos </strong>relacionados</p>
                </div>

                <div class="container">
                    <div class="main-slider__content">
                        
                        @foreach(App\Product::with('category')->inRandomOrder()->where('amount', '>', 0)->take(20)->get() as $product)
                            <a href="{{ url('/product/'.$product->slug) }}">
                                <div class="main-slider__item">
                                    <div class="content-slider">
                                        @if($product->is_external == false)
                                            <img src="{{ asset('/images/products/'.$product->picture) }}" alt="" style="width: 100%">
                                        @else
                                            <img src="{{ $product->picture }}" alt="" style="width: 100%">
                                        @endif
                                    </div>
                                    <div class="main-slider__text">
                                        <span>{{ $product->name }}</span>
                                        @if($product->category)
                                            <p class="title">{{ $product->category->name }}</p>
                                        @endif
                                        @if($product->external_price > 0)
                                            <span class="price">$ {{ number_format(intval($product->external_price * App\DolarPrice::first()->price), 0, ",", ".") }}</span>
                                        @else
                                        <span class="price">$ {{ number_format($product->price, 0, ",", ".") }}</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>

        </div>
    </div>

    @include('partials.footer')

@endsection

@push('scripts')
    
    <script>
            
        const app = new Vue({
            el: '#product-detail',
            data(){
                return{
                    productId:"{!! $product->id !!}",
                    modalTitle: "Añadir al carrito",
                    amount:1,
                    maxAmount:"{!! $product->amount !!}",
                    auth: '{!! \Auth::check() !!}'
                }
            },
            methods:{

                store(){

                    if(this.auth == ""){

                        this.localCart()

                    }else{

                        let formData = new FormData()
                        formData.append("productId", this.productId)
                        formData.append("amount", this.amount)

                        axios.post("{{ route('cart.store') }}", formData)
                        .then(res => {

                            if(res.data.success == true){

                                alertify.success(res.data.msg)
                                this.amount = 1;

                            }else{

                                alertify.error(res.data.msg)

                            }

                        })
                        .catch(err => {
                            
                            $.each(err.response.data.errors, function(key, value){
                                alertify.error(value)
                            });

                        })

                    }

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

                },
                localCart(){

                    let cart = []
                    if(window.localStorage.getItem('cart') != null){
                        cart =JSON.parse(window.localStorage.getItem('cart'))
                    }
                   
                    var exists = false

                    cart.forEach((data, index)=>{

                        if(data.productId == this.productId){
                            data.amount = data.amount + this.amount
                            exists = true
                        }

                    })
                    

                    if(exists == false){
                        cart.push({productId: this.productId, amount: this.amount})
                    }
                    
                    window.localStorage.setItem("cart", JSON.stringify(cart))

                    alert("Producto añadido al carrito")

                }

            },
            mounted(){
                //this.test()
            }

        })

    </script>

@endpush