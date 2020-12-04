@extends('layouts.main')

@section('content')

    <div class="container bg">
        <div id="product-detail">
            <section class="informacion-detalles container" v-cloak>
                <div class="">

                    <div class="col-sm-12 banner-productos">
                        <!--<div class="migas"><a href="#">Home </a> > <a href="#"> Computadores </a> > <a href="#">
                                Computadores
                                Portátiles</a> > <a href="#"> Hp </a>
                        </div>-->
                    </div>
                 <!---   <div class="row">
                        <div class="col-12">
                            <a class="btn btn-primary btn-general btn-general--form" style="color: #fff;" href="{{ url()->previous() }}"><i class="fa fa-arrow-left"></i></a>
                        </div>
                    </div>-->
                    <div class="row reverse_colum">
                        <div class="col-sm-6">

                            <div class="div-informacion-detalles">
                                <h2><strong>{{ $product->name }}</strong></h2>

                                @if($product->sale_price == null || $product->sale_price == 0)
                                    
                                    @if($product->percentage_range_profit > 0 && $product->percentage_range_profit != null)
                                        <h4>{{ number_format(intval($product->price_range_profit * App\DolarPrice::first()->price) + 1, 0, ",", ".") }}</h4>
                                    @else
                                        <h4>{{ number_format(intval($product->external_price * App\DolarPrice::first()->price) + 1, 0, ",", ".") }}</h4>
                                    @endif
                                
                                @else

                                    <h4 class="price" >$ {{ number_format(intval((App\DolarPrice::first()->price * $product->sale_price) + 1), 0,",", ".") }}</h4>

                                    @if($product->percentage_range_profit > 0 && $product->percentage_range_profit != null)
                                        <strike class="price">
                                            <small style="font-size: 14px; color: red;">$ {{ number_format((intval(App\DolarPrice::first()->price * $product->price_range_profit) + 1), 0, ",", ".") }}</small>
                                        </strike>
                                    @else
                                        <strike class="price">
                                            <small style="font-size: 14px; color: red;">$ {{  number_format((intval(App\DolarPrice::first()->price * $product->external_price) + 1), 0, ",", ".") }}</small>
                                        </strike>
                                    @endif

                                @endif

                                {{--<h3>$  @if($product->percentage_range_profit != 0 && $product->percentage_range_profit != null)
                                        {{ number_format(intval($product->price_range_profit * App\DolarPrice::first()->price) + 1, 0, ",", ".") }}
                                    @else
                                        {{ number_format(intval($product->external_price * App\DolarPrice::first()->price) + 1, 0, ",", ".") }}
                                    @endif--}}
                                
                                <h5>{{ $product->sub_title }}</h5>
                                <ul>
                                    
                                    <li><strong>VPN:</strong> {{ $product->sku }}</li>
                                    <li><strong>STOCK:</strong> {{ $product->amount }}</li>
                                </ul>

                                @if(\Auth::check() && \Auth::user())
                                <ul>
                                    <li>
                                        <i style="cursor:pointer; font-size: 40px;" class="fa fa-heart-o" @click="addToWishlist()" v-if="isFavorite == false"></i>
                                        <i style="cursor:pointer; font-size: 40px;" class="fa fa-heart" @click="removeFromWishlist()" v-else></i>
                                    </li>
                                </ul>
                                @endif


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
                                                                                                                
                                                <button class="btn btn-info" @click="store()">Añadir al Carrito</button>                                     
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
                                <img class="imagen-detalles" src="{{ $product->picture }}" alt="">
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

            <div v-cloak>
                <div class="beneficios">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="compra-protegida">
                                <div class="row">
                                    <div class="col-sm-4 text-center">
                                        <img src="{{ asset('/images/compra_segura_ds.png') }}" alt="">
                                    </div>
                                    <div class="col-sm-8">
                                        <h3>COMPRA PROTEGIDA</h3>
                                        <h5>Recibe de forma segura </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="compra-protegida p12">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <img class="p-2" src="{{ asset('/images/modo_de_pago_ds.png') }}" alt="">
                                    </div>
                                    <div class="col-sm-8">
                                        <h3>MEDIOS DE PAGO</h3>
                                        <h5>Tarjetas débito, crédito</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="compra-protegida p12 p-4">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <img class="p-1" src="{{ asset('/images/despacho-ds.png') }}" alt="">
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


            <div class="presentacion" v-cloak>
                <div class="row">
                    <div class="col-12">
                        @if($product->brand_id == 10)
                            <div id="wc-power-page"></div>
                        @endif

                    </div>
                </div>
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
                                </a>
                            </div>
                            
                            @if(count($product->items) > 0)
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
                                                @foreach(App\Feature::where("product_id", $product->id)->get() as $feature)
                                                    <tr>
                                                        <td>{{ $feature->feature }}</td>
                                                        <td>{{ $feature->description }}</td>
                                                    </tr>
                                                @endforeach
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @else
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
                                              
                                                @foreach(App\Feature::where("product_id", $product->id)->get() as $feature)
                                                    <tr>
                                                        <td>{{ $feature->feature }}</td>
                                                        <td>{{ $feature->description }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endif

                        </div>

                        {{--<div class="card">
                            <a class="collapsed card-link" data-toggle="collapse" href="#collapseTres">
                                <div class="card-header acordeon-2">
                                    <h2><strong>Calificación </strong>y Comentarios</h2>
                                </div>
                            </a>
                        </div>
                        
                        <div id="collapseTres" class="collapse" data-parent="#accordion">
                            <div class="card-body">
                                <div class="container comentarios">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            
                                            <div class="comentario" v-for="comment in comments ">
                                                <h3><strong>@{{ comment.comment.user.name }}</strong></h3>
                                                <h5>@{{ comment.date }}</h5>
                                                <p>@{{ comment.comment.comment }}
                                                </p>
                                            </div>
                                            
                                         
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                        <ul class="pagination">
                                            <li class="line-pag">
                                                <a class="page-link" v-if="page > 1" @click="fetch(1)">Primero</a>
                                            </li>
                                            <li class="line-pag line-pag_r" >
                                                <a class="page-link" v-if="page > 1" @click="fetch(page - 1)"><i class="fa fa-long-arrow-left" aria-hidden="true"></i>
                                                </a>
                                            </li>
                                            <li class="page-item" v-for="index in pages">
                                                <a class="page-link" style="background-color: #d32b2b; color: #fff !important;" v-if="page == index && index >= page - 3 &&  index < page + 3"  :key="index" @click="fetch(index)" >@{{ index }}</a>
                                                <a class="page-link" v-if="page != index && index >= page - 3 &&  index < page + 3"  :key="index" @click="fetch(index)" >@{{ index }}</a> 
                                            </li>
                                            <li class="line-pag">
                                                <a class="page-link" v-if="page < pages" @click="fetch(page + 1)"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                                                </a>
                                            </li>
                                            <li class="line-pag">
                                                <a class="page-link" v-if="page < pages" @click="fetch(pages)">último</a>
                                            </li>
                                        </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="line">
                                    @if(\Auth::check() && \Auth::user()->id)
                                        
                                        <div class="col-lg-8 offset-lg-2" style="margin-bottom: 10px;">
                                            <textarea class="form-control" row="3" v-model="comment"></textarea>
                                        </div>

                                        <button type="button" class="agregar-comentario" @click="storeComment()">Agregar Comentario</button>
                                    @else
                                        <p class="text-center">Debes iniciar sesión para dejar un comentario</p>
                                    @endif
                                </div>

                                
                                </div>

                            </div>
                        </div>--}}
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
                        
                        @foreach(App\Product::with('category', "brand")->has("category")->has("brand")->inRandomOrder()->where("brand_id", $product->brand_id)->where('amount', '>', 0)->take(20)->get() as $related)
                            <a href="{{ url('/product/'.$related->slug) }}">
                                <div class="main-slider__item">
                                    <div class="content-slider">
                                        @if($related->is_external == false)
                                            <img src="{{ asset('/images/products/'.$related->picture) }}" alt="" style="width: 100%">
                                        @elseif($related->data_source_id == 1 && $related->is_external == true)
                                            <img src="{{ $related->picture }}" alt="" style="width: 100%">
                                        @elseif($related->data_source_id == 2)
                                            <img src="{{ $related->picture }}" alt="" style="width: 100%">
                                        @endif
                                    </div>
                                    <div class="main-slider__text">
                                        <p class="title">{{ $related->name }}</p>
                                        <p class="title-brand">{{ $related->brand->name }}</p>
                                        @if($related->category)
                                            <span>{{ $related->category->name }}</span>
                                            <br>
                                        @endif
                                        @if($related->external_price > 0)
                                            <span class="price">$ {{ number_format(intval($related->external_price * App\DolarPrice::first()->price) + 1, 0, ",", ".") }}</span>
                                        @else
                                        <span class="price">$ {{ number_format($related->price, 0, ",", ".") }}</span>
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
    
    @if($product->brand_id == 10)

        <script>
            Webcollage.loadProductContent('deirastore-cl-es', "{{ $product->id }}", {"power-page":{autoPlayAndStop: true}})
        </script>

    @endif

    <script>
            
        const app = new Vue({
            el: '#product-detail',
            data(){
                return{
                    productId:"{!! $product->id !!}",
                    modalTitle: "Añadir al carrito",
                    amount:1,
                    pages:1,
                    page:1,
                    comments:[],
                    comment:"",
                    maxAmount:"{!! $product->amount !!}",
                    auth: '{!! \Auth::check() !!}',
                    isFavorite:false
                }
            },
            methods:{

                fetch(page = 1){

                    this.page = page

                    axios.post("{{ url('/comment/fetch') }}", {page: this.page, product_id: this.productId})
                    .then(res => {
                        
                        if(res.data.success == true){

                            this.comments = res.data.comments
                            this.pages = Math.ceil(res.data.commentsCount / res.data.dataAmount)

                        }

                    })

                },
                store(){

                    //if(this.auth == ""){

                        this.localCart()

                    /*}else{

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

                    }*/

                },
                storeComment(){

                    axios.post("{{ url('/comment') }}", {"product_id": this.productId, "comment": this.comment}).then(res => {

                        if(res.data.success == true){
                            this.comment = ""
                            alertify.success(res.data.msg)
                            this.fetch()

                        }else{

                            alertify.error(res.data.msg)

                        }

                    }).catch(err => {
                        
                        $.each(err.response.data.errors, function(key, value) {
                            alertify.error(value[0])
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
                        cart.push({productId: this.productId, amount: this.amount, stock: this.maxAmount})
                    }
                    
                    window.localStorage.setItem("cart", JSON.stringify(cart))

                    alertify.success("Producto añadido al carrito")

                },
                addToWishlist(){

                    axios.post("{{ url('wishlist-add') }}", {"productId": this.productId}).then(res => {

                        if(res.data.success == true){

                            alertify.success(res.data.msg)
                            this.isFavorite = true

                        }else{

                            alertify.error(res.data.msg)

                        }

                    })

                },
                removeFromWishlist(){

                    axios.post("{{ url('wishlist-remove') }}", {"productId": this.productId}).then(res => {

                        if(res.data.success == true){

                            alertify.success(res.data.msg)
                            this.isFavorite = false

                        }else{

                            alertify.error(res.data.msg)

                        }

                    })

                },
                checkWishlist(){

                    axios.post("{{ url('wishlist-check') }}", {"productId": this.productId}).then(res => {

                        if(res.data.wish != null){
                            this.isFavorite = true
                        }

                    })

                }

            },
            mounted(){
                this.fetch()
                this.checkWishlist()
                //this.test()

            }

        })

    </script>

@endpush