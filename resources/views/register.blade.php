@extends("layouts.main")

@section('content')
    @include('partials.navbar')

    <div class="container bg card-form">
        <div class="row center-form">
            <div class="col-lg-6  col-md-6  col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="title__general fadeInUp wow animated">
                            <p><strong>Registro</strong> de usuario </p>
                        </div>

                        <div class="form-grid">
                            <!-- input -->
                            <div class="form-grid__item">
                                <label  for="name">Nombre</label>
                                <input  placeholder="Ej: Pedro" type="text" class="form-control" id="name" aria-describedby="emailHelp" v-model="name">
                            </div>
                            <!-- input -->
                            <div class="form-grid__item">
                                <label  for="name">Apellido</label>
                                <input  placeholder="Ej: Perez " type="text" class="form-control" aria-describedby="emailHelp" v-model="lastname">
                            </div>
                            <!-- input -->
                            <div class="form-grid__item">
                                <label  for="genre">Género</label>
                                <select class="form-control" id="genre" v-model="genre">
                                    <option>Género</option>
                                    <option value="masculino">Masculino</option>
                                    <option value="femenino">Femenino</option>
                                    <option value="prefiero mantenerlo en privado">Prefiero mantenerlo en privado</option>
                                </select>
                            </div>
                            <!-- input -->
                            <div class="form-grid__item">
                                <label  for="birthDate">Fec. Nacimiento</label>
                                <input  placeholder="Fec. Nacimiento " type="date" class="form-control" id="birthDate" aria-describedby="emailHelp" v-model="birthDate">
                            </div>
                                <!-- input -->
                                <div class="form-grid__item inputcontainer">
                                    <label  for="rut">Rut</label>
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
                                    <!-- input -->
                        
                                <!-- input -->
                                <div class="form-grid__item">
                                    <label  for="phoneNumber">Celular</label>
                                    <input  placeholder="Ej: +00 1234567" type="text" class="form-control" id="phoneNumber" aria-describedby="emailHelp" v-model="phoneNumber" @keypress="isTelephoneNumber($event)">
                                </div>
                                    <!-- input -->
                            <div class="form-grid__item">
                                <label  for="email">Email</label>
                                <input  placeholder="Ej: email@gmail.com " type="email" class="form-control" id="email" aria-describedby="emailHelp" v-model="email">
                            </div>
                            <div class="form-grid__item">
                                <label  for="password">Contraseña</label>
                                <input  placeholder="Contraseña " type="password" class="form-control" id="password" v-model="password">
                            </div>

                            <div class="form-grid__item">
                                <label  for="passwordRepeat">Repetir Contraseña</label>
                                <input  placeholder="Repetir Contraseña " type="password" class="form-control" id="passwordRepeat" v-model="passwordRepeat">
                            </div>

                            <div class="form-grid__item form-check">
                                <input  type="checkbox" class="form-check-input mt-2" id="terms" v-model="terms">
                                <label  class="form-check-label mt-3" for="terms"><a href="{{ url('/terms') }}" target="_blank">Acepto terminos y condiciones</a></label>
                            </div>
                            <div class="form-grid__item mt-5 mb-3"> </div>
                            <div class="form-grid__item">
                                <div class="form-group text-center">
                                    <button class="btn btn-primary btn-general btn-general--form" @click="register()">Registrar</button>
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

@push('scripts')

<script>
    const app = new Vue({
        el: '#dev-app',
        data() {
            return {
                name: "",
                isRutValid:false,
                lastname:"",
                genre: "masculino",
                birthDate: "",
                rut: "",
                phoneNumber: "",
                email: '',
                password: "",
                passwordRepeat: "",
                terms: "",
                loading:false,
                reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/
            }
        },
        methods: {

            register() {

                if (!this.formHasErrors()) {

                    axios.post("{{ url('/register') }}", {
                            name: this.name,
                            genre: this.genre,
                            birthDate: this.birthDate,
                            rut: this.rut,
                            phoneNumber: this.phoneNumber,
                            email: this.email,
                            password: this.password,
                            lastname: this.lastname
                        })
                        .then(res => {
                            

                            if(res.data.success == true){

                                alert(res.data.msg)

                                this.name = ""
                                this.genre = "masculino"
                                this.birthDate = ""
                                this.rut = ""
                                this.phoneNumber = ""
                                this.email = ""
                                this.password = ""
                                this.passwordRepeat = ""
                                this.lastname = ""
                                this.terms = ""

                                window.location.href="{{ url('/') }}"
                            }else{

                                alert(res.data.msg)

                            }

                        })
                        .catch(err => {
                            $.each(err.response.data.errors, function(key, value) {
                                alert(value)
                            });
                        })

                }

            },
            formHasErrors() {

                let error = false

                if (this.name == "") {
                    alert("Campo nombre es requerido")
                    error = true
                }

                if (this.lastname == "") {
                    alert("Campo apellido es requerido")
                    error = true
                }

                if (this.genre == "") {
                    alert("Campo genero es requerido")
                    error = true
                }

                if (this.birthDate == "") {
                    alert("Campo fecha de nacimiento es requerido")
                    error = true
                }

                if (this.rut == "") {
                    alert("Campo rut es requerido")
                    error = true
                }

                if (this.phoneNumber == "") {
                    alert("Campo celular es requerido")
                    error = true
                }

                if (this.email == "") {
                    alert("Campo email es requerido")
                    error = true
                }

                if (this.password == "") {
                    alert("Campo clave es requerido")
                    error = true
                }

                if (this.password == "") {
                    alert("Campo repetir clave es requerido")
                    error = true
                }

                if (this.password != this.passwordRepeat) {
                    alert("Claves no coinciden")
                    error = true
                }

                if (this.terms == false) {
                    alert("Debe aceptar los terminos y condiciones")
                    error = true
                }

                if(this.isRutValid == false){
                    alert("Rut no válido")
                    error = true
                }

                if(!this.reg.test(this.email)){
                    alert("Email no válido")
                    error = true
                }

                return error

            },
            isNumber: function(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;

                if ((charCode > 31 && (charCode < 48 || charCode > 57))) {
                    evt.preventDefault();
                } else {
                    return true;
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
                            alert(res.data.msg)

                        }

                    })
                    .catch(err => {

                    })
                }
                
            }

        },
        mounted() {
            //this.test()
        }

    })
</script>

@endpush