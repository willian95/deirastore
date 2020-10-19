@extends('layouts.main')

@section('content')

    <div class="container pagina bg" v-cloak>

        <div class="loader-cover-custom" v-if="loading == true">
            <div class="loader-custom"></div>
        </div>

        <div class="row">
            
               <!--- <a class="btn btn-primary btn-general btn-general--form" style="color: #fff;" href="{{ url()->previous() }}"><i class="fa fa-arrow-left"></i></a>
            </div>--->
            <div class="col-12">
                <div class="title__general fadeInUp wow animated mt-5">
                    <p><strong>Pago </strong></p>
                </div>
               
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <p class="text-center">
                    <button class="btn btn-success btn-general2 pl-4 pr-4" @click="setBoleta()" v-if="!authCheck" data-toggle="modal" data-target="#boletaModal">Boleta</button>
                    <button class="btn btn-success btn-general2 pl-4 pr-4" v-else @click="boleta()">Boleta</button>
                </p>
            </div>
            
            <div class="col-6">
                <p class="text-center">
                    <button class="btn btn-success btn-general2 pl-4 pr-4 btn-general2_bg" v-if="!authCheck" @click="setFactura()" data-toggle="modal" data-target="#facturaModal">Factura</button>
                    <button class="btn btn-success btn-general2 pl-4 pr-4" v-else @click="factura()">Factura</button>
                </p>
                <p class="text-center">
                    {{ App\Text::where("site_location", "Tipo de facturación")->where("type", "texto")->first()->text }}
                </p>
            </div>
        
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td class="table__title">Producto</td>
                            <td class="table__title">Marca</td>
                            <td class="table__title">Nombre</td>
                            <td class="table__title">Precio</td>
                            <td class="table__title">Cantidad</td>
                            <td class="table__title">Total</td>
                            <!--<td class="table__title">Opciones de envío</td>-->

                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(item, index) in guestItem">
                            <td><img class="lista-pedido" :src="item.picture" alt=""></td>
                            <td v-if="item.brand_image != null"><img class="lista-pedido" :src="'{{ url('/') }}'+'/images/brands/'+item.brand_image" alt=""></td>
                            <td v-else>@{{ item.brand_name }}</td>
                            <td>
                                <span>@{{ item.name }} </span>
                                {{--<p>@{{ item.sub_title }}</p>--}}
                            </td>
                            <td>$ @{{ parseInt(item.price).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</td>
                            <td>
                                <div class="d-flex">
                                    
                                    <div class="text-center">
                                        @{{ item.amount }}
                                    </div>

                                </div>
                            </td>
                            <td>$ @{{ parseInt(item.price * item.amount).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</td>
                            {{--<td>
                                <select class="form-control shippingChoice" @change="updateCart(item.id)" :id="'shippingChoice'+item.id">
                                    <option value="1">Retiro en tienda</option>
                                    <option value="2" v-if="item.data_source_id == 2" :selected="item.shipping_method == 2">Despacho</option>
                                </select>
                            </td>--}}
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>


    </div>

            <!-- Modal -->
        <div class="modal fade" id="boletaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="modalCloseBoleta">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input placeholder="Email" type="text" autocomplete="off" class="form-control" id="email" aria-describedby="emailHelp" v-model="email">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="password">Contraseña</label>
                                    <input placeholder="Contraseña" type="password" autocomplete="off" class="form-control" id="password" aria-describedby="emailHelp" v-model="password">
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center mb-5 mt-3">
                            <button class="btn btn-dark" @click="login()">IDENTIFICATE</button>
                            <p class="text-center">
                                <small class="text-center" @click="register()" style="cursor:pointer;">¿Aún no tienes cuenta?</small>
                            </p>
                        </div>

                        <div class="form-group text-center mb-5 mt-3">
                            <button class="btn btn-primary btn-general btn-general--form" @click="showGuestModal()" data-toggle="modal" data-target="#guestModal">Continuar como invitado</button>
                        </div>

                        <div class="col-12">
                            <div>
                                <p class="text-center">
                                    {{--<button @click="redirectGoogle()" type="button" class="btn btn-success">Google</button>
                                    <button class="btn btn-success" disabled>Facebook</button>--}}
                                    <button class="loginBtn loginBtn--facebook" @click="redirectFacebook()">
                                        Inicia sesión con Facebook
                                    </button>
                                </p>
                                <p class="text-center">
                                    <button class="loginBtn loginBtn--google" @click="redirectGoogle()">
                                        Inicia sesión con  Google
                                    </button>
                                </p>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="guestModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Datos de invitado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="modalCloseBoleta">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Nombre</label>
                                    <input placeholder="Nombre" type="text" autocomplete="off" class="form-control" id="name" aria-describedby="emailHelp" v-model="name">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="lastname">Apellido</label>
                                    <input placeholder="Apellido" type="text" autocomplete="off" class="form-control" id="lastname" aria-describedby="emailHelp" v-model="lastname">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input placeholder="Email" type="text" autocomplete="off" class="form-control" id="email" aria-describedby="emailHelp" v-model="email">
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="inputcontainer">
                                    <label  for="rut">* Rut</label>
                                    <input placeholder="Ej: 121456789" type="text" class="form-control" id="rut" aria-describedby="emailHelp" v-model="rut" @blur="validateRut()">
                                    <div class="icon-container" v-if="rutLoading == true">
                                        <i class="loader"></i>
                                    </div>
                                    <div class="icon-container" v-if="rutLoading == false && isRutValid == true">
                                        <i class="fa fa-check-square"></i>
                                    </div>
                                    <div class="icon-container" v-if="rutLoading == false && isRutValid == false">
                                        <i class="fa fa-times"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="">
                                    <label  for="phoneNumber">* Celular</label>
                                    <input  placeholder="Ej: +56933123123" type="text" class="form-control" @focus="setNumber()" id="phoneNumber" aria-describedby="emailHelp" v-model="phoneNumber" @keypress="isTelephoneNumber($event)">
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-top: 10px;">
                                <div class="form-group text-center">
                                    <button :disabled="!isRutValid" class="btn btn-primary btn-general btn-general--form" @click="storeGuestUser()">Confirmar compra</button>
                                </div>
                            </div>
                            
                        </div>

                        


                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="facturaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="modalCloseBoleta">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input placeholder="Email" type="text" autocomplete="off" class="form-control" id="email" aria-describedby="emailHelp" v-model="email">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="password">Contraseña</label>
                                    <input placeholder="Contraseña" type="password" autocomplete="off" class="form-control" id="password" aria-describedby="emailHelp" v-model="password">
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center mb-5 mt-3">
                            <button class="btn btn-dark" @click="login()">IDENTIFICATE</button>
                            <p class="text-center">
                                <small class="text-center" @click="register()" style="cursor:pointer;">¿Aún no tienes cuenta?</small>
                            </p>
                        </div>

                        {{--<h5 class="text-center">¿Aún no tienes cuenta?</h5>
                        <div class="form-group text-center mb-5 mt-3">
                            <button class="btn btn-primary btn-general btn-general--form" @click="register()">Registrate</button>
                        </div>--}}


                        <div class="col-12">
                            <div>
                                <p class="text-center">
                                    {{--<button @click="redirectFacebook()" type="button" class="btn btn-success">Google</button>
                                    <button class="btn btn-success" disabled>Facebook</button>--}}
                                    <button  class="loginBtn loginBtn--facebook">
                                        Login with Facebook
                                    </button>
                                </p>
                                <p class="text-center">
                                    <button @click="redirectGoogle()" class="loginBtn loginBtn--google">
                                        Login with Google
                                    </button>
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    @include('partials.footer')

@endsection

@push("scripts")

    <script>

        const app = new Vue({
            el: '#dev-app',
            data(){
                return{
                    authCheck:false,
                    isRutValid:false,
                    email:"",
                    password:"",
                    phoneNumber:"",
                    rut:"",
                    name:"",
                    lastname:"",
                    rutLoading:"",
                    guestItem:[],
                    totalGuest:0,
                    loading:false
                }
            },
            methods:{
                setBoleta(){
                    localStorage.setItem("bill_type", "boleta")
                },
                setFactura(){
                    localStorage.setItem("bill_type", "factura")
                },
                boleta(){

                    axios.post("{{ url('/checkout/store-session') }}", {items: JSON.parse(localStorage.getItem("checkoutProduct")), type: "boleta", guestUser: JSON.parse(localStorage.getItem("guestUser")), user: JSON.parse(window.localStorage.getItem("guestUserLocation"))})
                    .then(res => {

                        if(res.data.success == true){
                            window.location.href = "{{ route('checkout') }}"
                        }

                    })

                },
                factura(){

                    window.location.href="{{ url('/checkout/factura') }}"

                },
                redirectGoogle(){

                    window.localStorage.setItem("deira_store_go_to_payment", true)

                    if(window.localStorage.getItem("bill_type") == "boleta"){
                        window.location.href="{{ url('auth/google?path=/cart/ticket') }}"
                    }else if(window.localStorage.getItem("bill_type") == "factura"){
                        window.location.href="{{ url('auth/google?path=/checkout/factura') }}"
                    }
                    

                },
                redirectFacebook(){

                    window.localStorage.setItem("deira_store_go_to_payment", true)

                    if(window.localStorage.getItem("bill_type") == "boleta"){
                        window.location.href="{{ url('auth/facebook?path=/cart/ticket') }}"
                    }else if(window.localStorage.getItem("bill_type") == "factura"){
                        window.location.href="{{ url('auth/facebook?path=/checkout/factura') }}"
                    }


                },
                register(){

                    window.localStorage.setItem("deira_store_go_to_payment", true)
                    window.location.href="{{ url('register') }}"

                },
                login(){
                    window.localStorage.setItem("deira_store_go_to_payment", true)

                    let path =""
                    if(window.localStorage.getItem("bill_type") == "boleta"){
                        path = "/cart/ticket"
                    }else if(window.localStorage.getItem("bill_type") == "factura"){
                        path = "/checkout/factura"
                    }

                    axios.post("{{ url('/login') }}", {
                        email: this.email,
                        password: this.password,
                        path:path
                    })
                    .then(res => {

                        if (res.data.success == false) {
                            alertify.error(res.data.msg)
                        } else {

                            if (res.data.user.rol_id == 1) {

                                //window.localStorage.removeItem("deira_store_go_to_payment")
                                window.location.href = res.data.path

                                
                            } else if (res.data.user.rol_id == 3) {
                                window.location.replace("{{ route('admin.dashboard') }}")
                            }

                        }

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value) {
                            alertify.error(value);
                            //alertify.alert('Basic: true').set('basic', true); 
                        });
                    })
                },
                showGuestModal(){

                    this.email =""
                    this.password = ""

                    $("#modalCloseBoleta").click();
                    $('body').removeClass('modal-open');
                    $('body').css('padding-right', '0px');
                    $('.modal-backdrop').remove();
                },
                validateRut(){
               
                    if(this.rut != ""){
                        this.rutLoading = true
                        axios.get("{{ url('/validate/rut/') }}"+"/"+this.rut).then(res => {
                            this.rutLoading = false
                            if(res.data.success == true){

                                this.isRutValid = res.data.data
                                
                            }else{
                                this.isRutValid = res.data.data
                                alertify.error(res.data.msg)

                            }

                        })
                        .catch(err => {

                        })
                    }
                    
                },
                setNumber(){

                    if(this.phoneNumber == ""){
                        this.phoneNumber = "+569"
                    }

                },
                isTelephoneNumber: function(evt) {
                    evt = (evt) ? evt : window.event;
                    var charCode = (evt.which) ? evt.which : evt.keyCode;

                    if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 43) {
                        evt.preventDefault();;
                    } else {
                        return true;
                    }
                },
                storeGuestUser(){

                    error = false
                    if(this.name == ""){
                        alertify.error("Nombre de invitado es requerido")
                        error = true
                    }

                    if(this.lastname == ""){
                        alertify.error("Apellido de invitado es requerido")
                        error = true
                    }

                    if(this.phoneNumber == ""){
                        alertify.error("Número teléfonico de invitado es requerido")
                        error = true
                    }else{
                        let regexp = /^(\+?56)?(\s?)(0?9)(\s?)[9876543]\d{7}$/
                        //let regexp = /^(\+?56)?(\s?)(\s?)[9876543]\d{7}$/
                        if(this.phoneNumber.match(regexp)){
                        
                        }else{
                            alertify.error("Número telefónico no válido")
                            error = true
                        }

                    }

                    if(this.rut == ""){
                        alertify.error("Rut de invitado es requerido")
                        error = true
                    }

                    if(this.email == ""){
                        alertify.error("Email de invitado es requerido")
                        error = true
                    }

                    if(!error){

                        let location = JSON.parse(window.localStorage.getItem("guestUserLocation"))

                        let guestUser = 
                        {
                            name: this.name,
                            lastname: this.lastname,
                            phoneNumber: this.phoneNumber,
                            rut: this.rut,
                            guestEmail: this.email,
                            location_id: "",
                            comune_id: "",
                            street: "",
                            number: "",
                            house: ""
                        }
       

                        if(location != null){
                            guestUser.location_id = location.location_id
                            guestUser.comune_id = location.commune_id
                            guestUser.street = location.street
                            guestUser.number = location.number
                            guestUser.house = location.house
                        }

                        /*newGuest.location_id = this.location
                        newGuest.comune_id = this.selectedComune
                        newGuest.street = this.street
                        newGuest.number = this.number
                        newGuest.house = this.house*/
                        
                        localStorage.setItem("guestUser", JSON.stringify(guestUser))
                        this.boleta()
                        //window.location.href="{{ url('/cart/shipping') }}"
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
                    
                }

            },
            mounted(){
                this.getGuestItems()
                this.authCheck = "{{ \Auth::check() }}"
            
                if(window.localStorage.getItem("deira_store_go_to_payment") == "true"){
                    
                    window.localStorage.removeItem("deira_store_go_to_payment")
                    
                    if(window.localStorage.getItem("bill_type") == "boleta"){
                        this.loading = true
                        this.boleta()
                    }else if(window.localStorage.getItem("bill_type") == "factura"){
                        if(this.authCheck == true){
                            this.loading = true
                            this.factura()
                        }
                        
                    }
                }

            }

        })

    </script>

@endpush