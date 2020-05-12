@extends('layouts.main')

@section('content')

    @include('partials.navbar')

    <div class="container pagina bg">
        <div class="carrito">
            <div id="cart">
                <div class="iconos-buy">
                    <div class="icono-p">
                        <div class="icono-buy__item">
                            <img src="assets/img/deira-48.png" alt="">
                        </div>
                        <div class="icono-buy__item">
                            <img src="assets/img/deira-49.png" alt="">
                        </div>
                        <div class="icono-buy__item">
                            <img src="assets/img/deira-50.png" alt="">
                        </div>
                        <div class="icono-buy__item">
                            <img src="assets/img/deira-51.png" alt="">
                        </div>
                        <div class="icono-buy__item">
                            <img src="assets/img/deira-52.png" alt="">
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <a class="btn btn-primary btn-general btn-general--form" style="color: #fff;" href="{{ url()->previous() }}"><i class="fa fa-arrow-left"></i></a>
                </div>

                <div class="row">
                    <div class="col-sm-12 ">

                        <div class="div-carrito">
                            <!-- <div class="iconos-carrito">
                                            <div class="icono-carrito"></div>
                                            <div class="icono-carrito"></div>
                                            <div class="icono-carrito"></div>
                                            <div class="icono-carrito"></div>
                                            <div class="icono-carrito"></div>
                                        </div> -->
                            <div class="title__general fadeInUp wow animated">
                                <p><strong>Carrito </strong>de compras</p>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td>Producto</td>
                                                <td>Marca</td>
                                                <td>Nombre</td>
                                                <td>Precio</td>
                                                <td>Cantidad</td>
                                                <td>Total</td>
                                                <td></td>

                                            </tr>
                                        </thead>
                                        @if(\Auth::check())
                                        <tbody>
                                            <tr v-for="item in items">
                                                <td v-if="item.product.is_external"><img class="lista-pedido" :src="item.product.picture" alt=""></td>
                                                <td v-else><img class="lista-pedido" :src="'{{ url('/') }}'+'/images/products/'+item.product.picture" alt=""></td>
                                                <td><img class="lista-pedido" :src="'{{ url('/') }}'+'/images/brands/'+item.product.brand.image" alt=""></td>
                                                <td>
                                                    <span>@{{ item.product.name }} </span>
                                                    <p>@{{ item.product.sub_title }}</p>
                                                </td>
                                                <td v-if="item.product.external_price > 0">$ @{{ parseInt(item.product.external_price * parseFloat(dolarPrice)).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</td>
                                                <td v-else>$ @{{ item.product.price }}</td>
                                                <td>@{{ item.amount }}</td>
                                                <td>$ @{{ parseInt(item.price).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</td>
                                                <td><button class="btn btn-danger" @click="erase(item.id)">X</button></td>
                                            </tr>

                                        </tbody>
                                        @else

                                        <tbody>
                                            <tr v-for="(item, index) in guestItem">
                                                <td v-if="item.is_external"><img class="lista-pedido" :src="item.picture" alt=""></td>
                                                <td v-else><img class="lista-pedido" :src="'{{ url('/') }}'+'/images/products/'+item.picture" alt=""></td>
                                                <td><img class="lista-pedido" :src="'{{ url('/') }}'+'/images/brands/'+item.brand_image" alt=""></td>
                                                <td>
                                                    <span>@{{ item.name }} </span>
                                                    <p>@{{ item.sub_title }}</p>
                                                </td>
                                                <td>$ @{{ item.price }}</td>
                                                <td>@{{ item.amount }}</td>
                                                <td>$ @{{ parseInt(item.price).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</td>
                                                <td><button class="btn btn-danger" @click="eraseGuestProduct(index)">X</button></td>
                                            </tr>

                                        </tbody>

                                        @endif
                                    </table>
                                    <div class="carrito-informacion">
                                        <div class="carrito_item" style="visibility: hidden;">
                                            <img src="assets/img/estadocompra.svg" alt="">
                                            <div>
                                                <p>ESTADO DE COMPRA </p>
                                                <span>Seguimiento online</span>
                                            </div>
                                        </div>
                                        <div class="carrito_item">
                                            <img src="assets/img/deira-47.png" alt="">
                                        </div>
                                        <div class="carrito_item">
                                            <img src="assets/img/auricular.svg" alt="">
                                            <div>
                                                <p>CONTÁCTANOS </p>
                                                <span>+56 22 674 8000</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="pedido">
                                        <h3>Tu pedido</h3>
                                        <h5>Total de tu compra</h5>
                                        @if(\Auth::check())
                                            <h2>$ @{{ parseInt(total).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</h2>
                                        @else
                                            <h2>$ @{{ parseInt(totalGuest).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</h2>
                                        @endif
                                        <p>Todos los valores incluyen iva</p>
                                      <div class="btn-buy">
                                        
                                            <div class="form-check">
                                                <input  type="checkbox" class="form-check-input mt-2" id="terms" v-model="terms">
                                                <label  class="form-check-label mt-3" for="terms"><a href="{{ url('/terms') }}" target="_blank">Acepto terminos y condiciones</a></label>
                                            </div>
                                       
                                        <button @click="keepShopping()"  class="finalizar-compra finalizar-compra--go">seguir comprando</button>
                                        <button @click="checkout()" class="finalizar-compra">checkout</button>
                                 
                                      </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>



            <!-- ofertas -->
            <section>
                <div class="title__general fadeInUp wow animated">

                    <p><strong>Te puede</strong> Interesar</p>
                </div>

                <div class="container">
                    <div class="main-slider__content">
                        @php
                        
                            $carts = App\Cart::with('product')->get();
                            $products = [];
                            
                            foreach($carts as $cart){
                                array_push($products, $cart->product->brand_id);
                            }

                            $query = App\Product::with("category");

                        @endphp

                        @if(count($carts) > 0)
                            @php
                                $randomProducts = $query->whereIn('brand_id', $products)->inRandomOrder()->take(10)->get();
                            @endphp
                        @else
                            @php
                                $randomProducts = $query->inRandomOrder()->where('amount', '>', 0)->take(10)->get()
                            @endphp
                        @endif

                        @foreach($randomProducts as $related)
                            <a href="{{ url('/product/'.$related->slug) }}">
                                <div class="main-slider__item">
                                    <div class="content-slider">
                                        @if($related->is_external == true)
                                            <img src="{{ $related->picture }}" alt="" style="width: 100%">
                                        @else
                                            <img src="{{ asset('images/products/'.$related->picture) }}" alt="">
                                        @endif
                                    </div>
                                    <div class="main-slider__text">
                                        <span>{{ $related->name }}</span>
                                        <p class="title">{{ $related->category->name }}</p>
                                        @if($related->external_price > 0 && $related->price == 0)
                                            <span class="price">$ {{ number_format($related->external_price * App\DolarPrice::first()->price, 0, ",", ".") }}</span>
                                        @else
                                            <span class="price">$ {{ number_format($related->price, 0, ",", ".") }}</span>
                                        @endif
                                        <!--<p class="price-old">Normal <span>$999.999</span></p>-->
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
            el: '#cart',
            data(){
                return{
                    modalTitle:"Editar articulo del carrito",
                    items:[],
                    amount:0,
                    maxAmount:0,
                    itemId:0,
                    total:0,
                    dolarPrice:'{!! App\DolarPrice::first()->price !!}',
                    authCheck:'{!! Auth::check() !!}',
                    guestItem:[],
                    totalGuest:0,
                    terms:false
                }
            },
            methods:{
                
                getItems(){

                    axios.get("{{ route('cart.items') }}")
                    .then(res => {
                        console.log("text-items", res)
                        this.items = res.data.products
                        this.total = res.data.total

                    })
                    .catch(err => {
                        console.log(err.response)
                    })
                
                },
                keepShopping(){
                    window.location.href="{{ url('/') }}"
                },
                edit(id, currentAmount, maxAmount){

                    this.itemId = id
                    this.amount = currentAmount
                    this.maxAmount = maxAmount

                },
                update(){

                    if(this.amount != 0){

                        axios.post("{{ route('cart.update') }}", {id: this.itemId, amount: this.amount})
                        .then(res => {

                            if(res.data.success == true){

                                alertify.success(res.data.msg)
                                this.getItems()

                            }
                            else{

                                alertify.error(res.data.msg)

                            }

                        })
                        .catch(err => {

                            $.each(err.response.data.errors, function(key, value){
                                alertify.error(value)
                            });

                        })

                    }else{
                        alertify.error("Campo cantidad no puede estar vacío")
                    }

                },
                erase(id){

                    if(confirm("¿Está seguro de eliminar este producto?")){
                        axios.post("{{ route('cart.delete') }}", {id: id})
                        .then(res => {
                            
                            if(res.data.success == true){

                                alertify.success(res.data.msg)
                                this.getItems()

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
                eraseGuestProduct(index){

                    if(confirm("¿Está seguro de eliminar este producto?")){
                        this.guestItem.splice(index, 1)
                        let cart = []
                        this.guestItem.forEach(function(data, index) {

                            cart.push({productId: data.id, amount: data.amount})

                        })

                        window.localStorage.setItem("cart", JSON.stringify(cart))
                        this.getGuestItems()
                    }

                },
                isNumber: function(evt) {

                    evt = (evt) ? evt : window.event;
                    var charCode = (evt.which) ? evt.which : evt.keyCode;

                    if ((charCode > 31 && (charCode < 48 || charCode > 57))) {
                        evt.preventDefault();

                    } else {

                        if(this.amount > this.maxAmount){
                            this.amount = this.maxAmount
                            evt.preventDefault()
                        }else{
                            return true;
                        }   
                        
                    }

                },
                payProducts(){

                    if(this.terms == true){
                        alertify.success("Debe aceptar los terminos y condiciones antes de continuar")
                    }else{
                        axios.post("{{ route('checkout') }}")
                        .then(res => {

                            if(res.data.success == true){
                                
                                this.getItems()
                                alertify.success(res.data.msg)

                            }else{
                                alertify.error(res.data.msg)
                            }

                        })
                        .cacth(err => {
                            $.each(err.response.data.errors, function(key, value){
                                alertify.error(value)
                            });
                        })
                    }

                },
                checkout(){
                    if(this.authCheck == 1)
                        window.location.href="{{ route('checkout') }}"
                    else
                        window.location.href="{{ url('/guest/checkout/') }}"
        
                },
                getGuestItems(){
                    let products = JSON.parse(window.localStorage.getItem('cart'))
                    
                    if(products != null){
                        
                        axios.post("{{ url('/guestCart') }}", {products: products}).then(res => {
                            this.guestItem = res.data.cart
                            this.totalGuest = res.data.total
                        })

                    }
                    

                }


            },
            mounted(){
                if(this.authCheck == 1){
                    this.getItems()
                }
                else{   
                    this.getGuestItems()
                }
                    
            }

        })
    
    </script>

@endpush