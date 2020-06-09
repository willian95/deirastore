@extends('layouts.main')

@section('content')

    <div class="container bg card-form">
        <div class="row center-form">
            <div class="col-lg-8  col-md-8  col-12">
                <div class="card">
                    <div class="card-body">
                        @if(\Auth::guest())
                        <div class="title__general fadeInUp wow animated">
                            <p><strong>Usuario</strong> Registrado</p>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input placeholder="Eamil" type="text" autocomplete="off" class="form-control" id="email" aria-describedby="emailHelp" v-model="email">
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
                            <button class="btn btn-primary btn-general btn-general--form" @click="logIn()">Login</button>
                        </div>

                        
                        <div class="title__general fadeInUp wow animated">
                            <p><strong>Información</strong> de usuario invitado</p>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nombre</label>
                                    <input placeholder="Nombre" type="text" autocomplete="off" class="form-control" id="name" aria-describedby="emailHelp" v-model="name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lastname">Apellido</label>
                                    <input placeholder="Apellido" type="text" autocomplete="off" class="form-control" id="lastname" aria-describedby="emailHelp" v-model="lastname">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="">
                                    <label  for="phoneNumber">* Celular +569</label>
                                    <input  placeholder="Ej: 33123123" type="text" class="form-control" id="phoneNumber" aria-describedby="emailHelp" v-model="phoneNumber" @keypress="isTelephoneNumber($event)">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="inputcontainer">
                                    <label  for="rut">* Rut</label>
                                    <input placeholder="Ej: 121456789" type="text" class="form-control" id="rut" aria-describedby="emailHelp" v-model="rut" @keypress="isAlphaNumeric($event)" @blur="validateRut()">
                                    <div class="icon-container" v-if="loading == true">
                                        <i class="loader"></i>
                                    </div>
                                    <div class="icon-container" v-if="loading == false && isRutValid == true">
                                        <i class="fa fa-check-square"></i>
                                    </div>
                                    <div class="icon-container" v-if="loading == false && isRutValid == false">
                                        <i class="fa fa-times"></i>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="emailGuest">Email</label>
                            <input placeholder="Correo electrónico" type="email" autocomplete="off" class="form-control" id="emailGuest" aria-describedby="emailHelp" v-model="guestEmail">
                        </div>

                        <div class="form-group text-center">
                            <button class="btn btn-primary btn-general btn-general--form" @click="storeGuestUser()">Confirmar compra</button>
                        </div>
                        @endif


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
        el: '#dev-app',
        data() {
            return {
                loading:false,
                email: '',
                password:"",
                name: "",
                lastname:"",
                phoneNumber:"",
                rut:"",
                guestEmail:"",
                isRutValid:false
            }
        },
        methods: {

            /*store() {

                axios.post("{{ url('/guest/store') }}", {
                    email: this.email,
                    name: this.name,
                    address: this.address,
                    location: this.location
                })
                .then(res => {

                    if(res.data.success == true){
                        let cart = window.localStorage.getItem("cart")
                        window.location.href="{{ url('/checkout/') }}"+"?cart="+cart+"&"+"email="+this.email+"&name="+this.name+"&location="+this.location
                    }

                })
                .catch(err => {
                    $.each(err.response.data.errors, function(key, value) {
                        alertify.error(value[0])
                    });
                })

            },*/
            /*getPrice(){

                let products = JSON.parse(window.localStorage.getItem('cart'))
                    
                if(products != null){

                    axios.post("{{ url('/guest/carts/prices') }}", {products: products, location: this.location})
                    .then(res => {
                        this.totalGuest = res.data.total
                        this.shippingCost = res.data.shippingCost
                        this.totalGuest = this.shippingCost + this.totalGuest
                    })

                }

            },*/
            regionChange(){

                axios.get("{{ url('/comune/by-region') }}"+"/"+this.location).then(res =>{
                    //console.log("test-region-change", res)
                    if(res.data.success == true){
                        this.communes = res.data.comunes
                    }
                })

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
           logIn() {

                if (!this.formHasErrors()) {

                    axios.post("{{ url('/login') }}", {
                        email: this.email,
                        password: this.password
                    })
                    .then(res => {

                        if (res.data.success == false) {
                            alertify.error(res.data.msg)
                        } else {

                            if (res.data.user.rol_id == 1) {
                                window.location.replace("{{ url('/cart/shipping') }}")
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

                }

            },
            formHasErrors() {

                let error = false

                if (this.email == "") {
                    //alert('Campo email es obligatorio')
                    alertify.error('Campo email es obligatorio');
                    error = true
                }

                if (this.password == "") {
                    alertify.error('Campo clave es obligatorio');
                    error = true
                }

                return error

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
                    //let regexp = /^(\+?56)?(\s?)(0?9)(\s?)[9876543]\d{7}$/
                    let regexp = /^(\+?56)?(\s?)(\s?)[9876543]\d{7}$/
                    let phone = "+56"+this.phoneNumber
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

                if(this.guestEmail == ""){
                    alertify.error("Email de invitado es requerido")
                    error = true
                }

                if(!error){

                    let guestUser = 
                        {
                            name: this.name,
                            lastname: this.lastname,
                            phoneNumber: this.phoneNumber,
                            rut: this.rut,
                            guestEmail: this.guestEmail
                        }
        
                    
                    localStorage.setItem("guestUser", JSON.stringify(guestUser))
                    window.location.href="{{ url('/cart/shipping') }}"
                }

            },
            isAlphaNumeric(evt){

                evt = (evt) ? evt : window.event;

                var letters = /^[0-9a-zA-Z]+$/;
                if(evt.key.match(letters))
                {
                    return true;
                }
                else
                {
                    evt.preventDefault();
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
        mounted() {
            //this.getPrice()
        }

    })
</script>

@endpush