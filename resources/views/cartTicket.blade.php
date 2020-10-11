@extends('layouts.main')

@section('content')

    <div class="container pagina bg" v-cloak>

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
                    <button class="btn btn-success btn-general2 pl-4 pr-4" v-if="!authCheck" @click="boleta()" data-toggle="modal" data-target="#boletaModal">Boleta</button>
                </p>
            </div>
            
            <div class="col-6">
                <p class="text-center">
                    <button class="btn btn-success btn-general2 pl-4 pr-4 btn-general2_bg" @click="factura()">Factura</button>
                </p>
                <p class="text-center">
                    {{ App\Text::where("site_location", "Tipo de facturación")->where("type", "texto")->first()->text }}
                </p>
            </div>
        
        </div>


    </div>

            <!-- Modal -->
        <div class="modal fade" id="boletaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="modalCloseBoleta">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input placeholder="Email" type="text" autocomplete="off" class="form-control" id="email" aria-describedby="emailHelp" v-model="email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Contraseña</label>
                                    <input placeholder="Contraseña" type="password" autocomplete="off" class="form-control" id="password" aria-describedby="emailHelp" v-model="password">
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center mb-5 mt-3">
                            <button class="btn btn-primary btn-general btn-general--form" @click="login()">Login</button>
                        </div>

                        <h5 class="text-center">¿Aún no tienes cuenta?</h5>
                        <div class="form-group text-center mb-5 mt-3">
                            <button class="btn btn-primary btn-general btn-general--form">Registrate</button>
                        </div>


                        <div class="col-12">
                            <div style="display:flex;">
                                <button @click="redirectGoogle()" type="button" class="btn btn-success">Google</button>
                                <button class="btn btn-success">Facebook</button>
                            </div>
                        </div>

                        <div class="form-group text-center mb-5 mt-3">
                            <button class="btn btn-primary btn-general btn-general--form" @click="showGuestModal()" data-toggle="modal" data-target="#guestModal">Continuar como invitado</button>
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
                                    <label for="email">Nombre</label>
                                    <input placeholder="Email" type="text" autocomplete="off" class="form-control" id="email" aria-describedby="emailHelp" v-model="name">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="lastname">Apellido</label>
                                    <input placeholder="Apellido" type="text" autocomplete="off" class="form-control" id="lastname" aria-describedby="emailHelp" v-model="lastname">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="">
                                    <label  for="phoneNumber">* Celular</label>
                                    <input  placeholder="Ej: +56933123123" type="text" class="form-control" @focus="setNumber()" id="phoneNumber" aria-describedby="emailHelp" v-model="phoneNumber" @keypress="isTelephoneNumber($event)">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="inputcontainer">
                                    <label  for="rut">* Rut</label>
                                    <input placeholder="Ej: 121456789" type="text" class="form-control" id="rut" aria-describedby="emailHelp" v-model="rut" @keypress="isAlphaNumeric($event)" @blur="validateRut()">
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
                    rut:""
                }
            },
            methods:{
                
                boleta(){

                    localStorage.setItem("bill_type", "boleta")

                    axios.post("{{ url('/checkout/store-session') }}", {items: JSON.parse(localStorage.getItem("checkoutProduct")), type: "boleta", guestUser: JSON.parse(localStorage.getItem("guestUser"))})
                    .then(res => {

                        if(res.data.success == true){
                            window.location.href = "{{ route('checkout') }}"
                        }

                    })

                },
                factura(){

                    localStorage.setItem("bill_type", "factura")
                    axios.post("{{ url('/checkout/store-session') }}", {items: JSON.parse(localStorage.getItem("checkoutProduct")), type: "factura"})
                    .then(res => {
                        if(res.data.success == true){
                            window.location.href = "{{ route('checkout') }}"
                        }

                    })

                },
                redirectGoogle(){

                    window.localStorage.setItem("deira_store_go_to_payment", true)
                    window.location.href="{{ url('auth/google?path=/cart/ticket') }}"

                },
                login(){
                    window.localStorage.setItem("deira_store_go_to_payment", true)
                    axios.post("{{ url('/login') }}", {
                        email: this.email,
                        password: this.password,
                        path:"/cart/ticket"
                    })
                    .then(res => {

                        if (res.data.success == false) {
                            alertify.error(res.data.msg)
                        } else {

                            if (res.data.user.rol_id == 1) {
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
                        this.loading = true
                        axios.get("{{ url('/validate/rut/') }}"+"/"+this.rut).then(res => {
                            this.loading = false
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
                }

            },
            mounted(){
                this.authCheck = "{{ \Auth::check() }}"

                if(window.localStorage.getItem("deira_store_go_to_payment") == "true"){
                    windo.localStorage.removeItem("deira_store_go_to_payment")
                    this.boleta()
                }

            }

        })

    </script>

@endpush