@extends("layouts.main")

@section('content')
    @include('partials.navbar')

    <div class="container bg card-form">
        <div class="row center-form">
            <div class="col-lg-4  col-md-6  col-12">
                <div class="card">
                    <div class="card-body">
                    <div class="title__general">
                            <p><strong>Registro</strong> de usuario </p>
                        </div>

                        <div class="form-group">
                            <label hidden  for="name" hidden>Nombre</label>
                            <input placeholder="Nombre" type="text" class="form-control" id="name" aria-describedby="emailHelp" v-model="name">
                        </div>
                        <div class="form-group">
                            <label hidden  for="name" hidden>Apellido</label>
                            <input placeholder="Apellido" type="text" class="form-control" aria-describedby="emailHelp" v-model="lastname">
                        </div>
                        <div class="form-group">
                            <label hidden  for="genre">Género</label>
                            <select class="form-control" id="genre" v-model="genre">
                                <option >Género</option>
                                <option value="masculino" selected>Masculino</option>
                                <option value="femenino">Femenino</option>
                                <option value="prefiero mantenerlo en privado">Prefiero mantenerlo en privado</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label hidden  for="birthDate">Fec. Nacimiento</label>
                            <input placeholder="Fec. Nacimiento" type="date" class="form-control" id="birthDate" aria-describedby="emailHelp" v-model="birthDate">
                        </div>
                        <div class="form-group inputcontainer">
                            <label hidden  for="rut">Rut</label>
                            <input placeholder="Rut" type="text" class="form-control" id="rut" aria-describedby="emailHelp" v-model="rut" @keypress="isAlphaNumeric($event)" @blur="validateRut()">
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
                        <div class="form-group">
                            <label hidden  for="phoneNumber">Celular</label>
                            <input placeholder="Celular" type="text" class="form-control" id="phoneNumber" aria-describedby="emailHelp" v-model="phoneNumber" @keypress="isTelephoneNumber($event)">
                        </div>
                        <div class="form-group">
                            <label hidden  for="email">Email</label>
                            <input placeholder="Email" type="email" class="form-control" id="email" aria-describedby="emailHelp" v-model="email">
                        </div>
                        <div class="form-group">
                            <label hidden  for="password">Contraseña</label>
                            <input placeholder="Contraseña" type="password" class="form-control" id="password" v-model="password">
                        </div>
                        <div class="form-group">
                            <label hidden  for="passwordRepeat">Repetir Contraseña</label>
                            <input placeholder="Repetir Contraseña" type="password" class="form-control" id="passwordRepeat" v-model="passwordRepeat">
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="terms" v-model="terms">
                            <label  class="form-check-label" for="terms"><a href="{{ url('/terms') }}" target="_blank">Acepto terminos y condiciones</a></label>
                        </div>
                        <div class="form-group text-center">
                            <button class="btn btn-primary btn-general btn-general--form" @click="register()">Registrar</button>
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

        },
        mounted() {
            //this.test()
        }

    })
</script>

@endpush