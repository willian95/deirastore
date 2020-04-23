@extends('layouts.main')

@section('content')

    @include('partials.navbar')

    <div class="container pagina bg">
        <div class="carrito">
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
                        <div class="title__general">
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
                                </table>
                                <div class="carrito-informacion">
                                    <div class="carrito_item">
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
                                    <h2>$ @{{ parseInt(total).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</h2>
                                    <p>Todos los valores incluyen iva</p>
                                    <button @click="checkout()" class="finalizar-compra">checkout</button>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>


            </div>



            <!-- ofertas -->
            <section>
                <div class="title__general">

                    <p><strong>Te puede</strong> Interesar</p>
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
            </section>




        </div>

    </div>

    @include('partials.footer')

@endsection

@push('scripts')
    
    <script>
        
        const app = new Vue({
            el: '#dev-app',
            data(){
                return{
                    modalTitle:"Editar articulo del carrito",
                    items:[],
                    amount:0,
                    maxAmount:0,
                    itemId:0,
                    total:0,
                    dolarPrice:'{!! App\DolarPrice::first()->price !!}'
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

                                alert(res.data.msg)
                                this.getItems()

                            }
                            else{

                                alert(res.data.msg)

                            }

                        })
                        .catch(err => {

                            $.each(err.response.data.errors, function(key, value){
                                alert(value)
                            });

                        })

                    }else{
                        alert("Campo cantidad no puede estar vacío")
                    }

                },
                erase(id){

                    if(confirm("¿Está seguro de eliminar este producto?")){
                        axios.post("{{ route('cart.delete') }}", {id: id})
                        .then(res => {
                            
                            if(res.data.success == true){

                                alert(res.data.msg)
                                this.getItems()

                            }else{

                                alert(res.data.msg)

                            }

                        })
                        .catch(err => {
                            $.each(err.response.data.errors, function(key, value){
                                alert(value)
                            });
                        })
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

                    axios.post("{{ route('checkout') }}")
                    .then(res => {

                        if(res.data.success == true){
                            
                            this.getItems()
                            alert(res.data.msg)

                        }else{
                            alert(res.data.msg)
                        }

                    })
                    .cacth(err => {
                        $.each(err.response.data.errors, function(key, value){
                            alert(value)
                        });
                    })

                },
                checkout(){
                    window.location.href="{{ route('checkout') }}"
                }


            },
            mounted(){
                this.getItems()
            }

        })
    
    </script>

@endpush