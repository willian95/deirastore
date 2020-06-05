@extends('layouts.main')

@section('content')

    <div class="container pagina bg">
        <div class="carrito">
            <div id="cart">
                <div class="iconos-buy">
                    <div class="icono-p">
                        <div class="icono-buy__item">
                            <img src="{{ asset('assets/img/deira-48.png') }}" alt="">
                        </div>
                        <div class="icono-buy__item">
                            <img src="{{ asset('assets/img/deira-49.png') }}" alt="">
                        </div>
                        <div class="icono-buy__item">
                            <img src="{{ asset('assets/img/deira-50.png') }}" alt="">
                        </div>
                        <div class="icono-buy__item">
                            <img src="{{ asset('assets/img/deira-51.png') }}" alt="">
                        </div>
                        <div class="icono-buy__item">
                            <img src="{{ asset('assets/img/deira-52.png') }}" alt="">
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
                                <div class="col-md-12 col-lg-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td>Producto</td>
                                                <td>Marca</td>
                                                <td>Nombre</td>
                                                <td>Precio</td>
                                                <td>Cantidad</td>
                                                <td>Total</td>
                                                <td>Opciones de envío</td>

                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr v-for="(item, index) in guestItem">
                                                <td><img class="lista-pedido" :src="item.picture" alt=""></td>
                                                <td v-if="item.brand_image != null"><img class="lista-pedido" :src="'{{ url('/') }}'+'/images/brands/'+item.brand_image" alt=""></td>
                                                <td v-else>@{{ item.brand_name }}</td>
                                                <td>
                                                    <span>@{{ item.name }} </span>
                                                    <p>@{{ item.sub_title }}</p>
                                                </td>
                                                <td>$ @{{ item.price }}</td>
                                                <td>@{{ item.amount }}</td>
                                                <td>$ @{{ parseInt(item.price * item.amount).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</td>
                                                <td>
                                                    <select class="form-control" @change="updateCart(item.id)" :id="'shippingChoice'+item.id">
                                                        <option value="1">Retiro en tienda</option>
                                                        <option value="2" v-if="item.data_source_id == 2" :selected="item.shipping_method == 2">Despacho</option>
                                                    </select>
                                                </td>
                                            </tr>

                                        </tbody>

                                    </table>
                                    <!--<div style="width: 120px; float: right;">
                                        <p style="text-align: center; font-size: 10px;">Hay productos que solo pueden ser retirados en nuestras dependencias. En ese caso solo se desplegará la opción "Retiro en tienda"</p>
                                    </div>-->
                                </div>
                                <!--<div class="col-md-12 col-lg-4">
                                    <div class="pedido">
                                        
                                        

                                    </div>
                                </div>-->
                            </div>
                        </div>

                    </div>


                </div>

                <div class="row">
                    <div class="col-lg-8 col-md-12">

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label >* Región</label>
                                    <select class="form-control" v-model="location" @change="regionChange()">
                                        @foreach(App\Region::all() as $region)
                                            <option :value="{{ $region->id }}">{{ $region->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label  for="comuna">* Comuna</label>
                                    <select class="form-control" v-model="selectedComune">
                                        
                                        <option v-for="comune in communes" :value="comune.id">@{{ comune.name }}</option>
                                        
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label  for="street">* Calle</label>
                                    <input  placeholder="Ingresa nombre de la calle" type="text" class="form-control" id="street" v-model="street">
                                </div>
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label  for="number">* Número</label>
                                    <input  placeholder="Ingresa número" type="text" class="form-control" id="number" v-model="number">
                                </div>
                                <div class="col-md-6">
                                    <label  for="house">Dpto. / Casa / Oficna (Opcional)</label>
                                    <input  placeholder="Ingresa número" type="text" class="form-control" id="house" v-model="house">
                                </div>
                            </div>
                            
                        </div>

                        <p class="text">
                            <button class="btn btn-success" @click="updateCartLocation()">Confirmar ubicación</button>
                        </p>

                    </div>
                    <div class="col-md-12 col-lg-4">
                        <div class="pedido">
                            <h3>Tu pedido</h3>
                            <h5>Total de tu compra</h5>
                            <strong><small>Solo productos</small></strong>
                            
                            <h2>$ @{{ parseInt(totalGuest).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</h2>
                          

                            <strong><small>Productos + despacho</small></strong>
                            
                            <h2>$ @{{ parseInt(totalGuest +  shippingCost).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</h2>
                            
                            
                            <p>Todos los valores incluyen iva</p>

                            <p>Recuerda que @{{ shippingAmount }} de @{{ guestItem.length }} productos estará siendo despachado.</p>
                            <p>En caso de tener que retirar un producto deberás hacerlo en nuestras dependencias.</p>
                            <p>Más información al final del presente sitio</p>

                            <div class="btn-buy">
                                
                                <div class="form-check">
                                    <input  type="checkbox" class="form-check-input mt-2" id="terms" v-model="terms">
                                    <label  class="form-check-label mt-3" for="terms"><a href="{{ url('/terms') }}" target="_blank">Acepto terminos y condiciones</a></label>
                                </div>
                                <button @click="ticketView()" class="btn btn-success">continuar</button>
                                
                            </div>

                        </div>
                    </div>
                </div>

            </div>

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
                    shippingCost:0,
                    terms:false,
                    location:"",
                    selectedComune:"",
                    street:"",
                    number:"",
                    house:"",
                    communes:[],
                    cartAmount:0,
                    shippingAmount:0,
                    confirmAddress:false
                }
            },
            methods:{
                
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
                getGuestItems(){
                    let products = JSON.parse(window.localStorage.getItem('cart'))
                    
                    if(products != null){
                        
                        axios.post("{{ url('/guestCart') }}", {products: products}).then(res => {
                            this.guestItem = res.data.cart
                            this.totalGuest = res.data.total
                        })

                    }
                    
                },
                regionChange(){
                    this.selectedComune = ""
                    axios.get("{{ url('/comune/by-region') }}"+"/"+this.location).then(res =>{
                        //console.log("test-region-change", res)
                        if(res.data.success == true){
                            this.communes = res.data.comunes
                        }
                    })

                },
                updateCart(id){
                    
                    var  shippingMethod = $("#shippingChoice"+id).val()
                    axios.post("{{ url('/cart/shipping-price') }}", {products: this.guestItem, productId: id, shippingMethod: shippingMethod, location: this.location})
                    .then(res => {

                        this.guestItem = res.data.cart
                        this.totalGuest = 0;
                        this.shippingCost = 0;
                        this.shippingAmount = 0;

                        this.guestItem.forEach((data, index) => {

                            this.shippingCost += data.shipping_cost
                            this.totalGuest += data.price * data.amount
                            
                            if(data.shipping_method == 2){
                                this.shippingAmount++
                            }

                        })

                    })

                },
                ticketView(){

                    if(this.terms && this.confirmAddress == true){
                        var newGuest ={
                            name : "",
                            name : "",
                            lastname : "",
                            phoneNumber : "",
                            rut : "",
                            guestEmail : "",
                            location_id : "",
                            comnue_id : "",
                            street : "",
                            number : "",
                            house : ""

                        }
                        //let address = []
                        let guestUser = JSON.parse(localStorage.getItem("guestUser"))
                        console.log("test-guestuser", guestUser)
                        /*address.location_id = this.location
                        address.comnue_id = this.selectedComune
                        address.street = this.street
                        address.number = this.number
                        address.house = this.house*/

                        newGuest.name = guestUser.name
                        newGuest.lastname = guestUser.lastname
                        newGuest.phoneNumber = guestUser.phoneNumber
                        newGuest.rut = guestUser.rut
                        newGuest.guestEmail = guestUser.guestEmail
                        newGuest.location_id = this.location
                        newGuest.comune_id = this.selectedComune
                        newGuest.street = this.street
                        newGuest.number = this.number
                        newGuest.house = this.house

                        
                        window.localStorage.setItem("guestUser", JSON.stringify(newGuest))
                        window.localStorage.setItem("checkoutProduct", JSON.stringify(this.guestItem))
                        window.location.href = "{{ url('/cart/ticket') }}"
                    }else{
                        alertify.error("Debe aceptar los terminos y condiciones y confirma su dirección")
                    }

                },
                updateCartLocation(){
                    
                    let error = false

                    if(this.location == ""){
                        alertify.error("Debe seleccionar una región")
                        error = true
                    }

                    if(this.selectedComune == ""){
                        alertify.error("Debe seleccionar una comuna")
                        error = true
                    }

                    if(this.street == ""){
                        alertify.error("Debe ingresar una calle")
                        error = true
                    }

                    if(this.number == ""){
                        alertify.error("Debe ingresar un número")
                        error = true
                    }

                    if(error == false){
                        this.confirmAddress = true
                        alertify.success("Dirección confirmada")
                        axios.post("{{ url('/cart/shipping-price/location') }}", {products: this.guestItem, location: this.location}).then(res =>{
                        
                            this.guestItem = res.data.cart
                            this.totalGuest = 0;
                            this.shippingCost = 0;
                            this.shippingAmount = 0;
                            

                            this.guestItem.forEach((data, index) => {

                                this.shippingCost += data.shipping_cost
                                this.totalGuest += data.price * data.amount
                                if(data.shipping_method == 2){
                                    this.shippingAmount++
                                }

                            })
                            
                        })


                    }
                    
                }


            },
            mounted(){

                  
                this.getGuestItems()
                
                if(this.authCheck == 1){
                    this.location = "{!! Auth::check() ? Auth::user()->location_id : '' !!}"
                    this.selectedComune = "{!! Auth::check() ? Auth::user()->comune_id : '' !!}"
                    this.street = "{!! Auth::check() ? Auth::user()->street : ''  !!}"
                    this.number = "{!! Auth::check() ? Auth::user()->number : '' !!}"
                    this.house = "{!! Auth::check() ? Auth::user()->house : '' !!}"

                    this.confirmAddress = true

                }

                axios.get("{{ url('/comune/by-region') }}"+"/"+this.location).then(res =>{
                    //console.log("test-region-change", res)
                    if(res.data.success == true){
                        this.communes = res.data.comunes
                    }
                })
                    
            }

        })
    
    </script>

@endpush