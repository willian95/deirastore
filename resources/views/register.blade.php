@extends("layouts.main")

@section('content')
    @include('partials.navbar')
    <div class="container bg card-form">
        <div class="row center-form">
            <div class="col-lg-6  col-md-6  col-12">
                <div class="card">
                    <div class="card-body">
                    <div class="title__general">
                            <p><strong>Registro</strong> de usuario </p>
                        </div>
                        <div class="form-grid">
                            <!-- input -->
                            <div class="form-grid__item">
                                <label hidden  for="name" hidden>Nombre Completo</label>
                                <input  placeholder="Nombre Completo" type="text" class="form-control" id="name" aria-describedby="emailHelp" v-model="name">
                            </div>
                            <!-- input -->
                        
                            <!-- input -->
                            <div class="form-grid__item">
                                <label hidden  for="genre">Género</label>
                                <select class="form-control" id="genre" v-model="genre">
                                    <option value="M" >Género</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                    <option value="F">Prefiero mantenerlo en privado</option>
                                </select>
                            </div>
                            <!-- input -->
                            <div class="form-grid__item">
                                <label hidden  for="birthDate">Fec. Nacimiento</label>
                                <input  placeholder="Fec. Nacimiento" type="date" class="form-control" id="birthDate" aria-describedby="emailHelp" v-model="birthDate">
                            </div>
                                <!-- input -->
                                <div class="form-grid__item">
                                    <label hidden  for="rut">Rut</label>
                                    <input  placeholder="Rut" type="text" class="form-control" id="rut" aria-describedby="emailHelp" v-model="rut" @keypress="isNumber($event)">
                                </div>
                                    <!-- input -->
                        
                                <!-- input -->
                                <div class="form-grid__item">
                                    <label hidden  for="phoneNumber">Celular</label>
                                    <input  placeholder="Celular" type="text" class="form-control" id="phoneNumber" aria-describedby="emailHelp" v-model="phoneNumber" @keypress="isTelephoneNumber($event)">
                                </div>
                                    <!-- input -->
                            <div class="form-grid__item">
                                <label hidden  for="email">Email</label>
                                <input  placeholder="Email" type="email" class="form-control" id="email" aria-describedby="emailHelp" v-model="email">
                            </div>
                            <div class="form-grid__item">
                                <label hidden  for="password">Contraseña</label>
                                <input  placeholder="Contraseña" type="password" class="form-control" id="password" v-model="password">
                            </div>

                            <div class="form-grid__item">
                                <label hidden  for="passwordRepeat">Repetir Contraseña</label>
                                <input  placeholder="Repetir Contraseña" type="password" class="form-control" id="passwordRepeat" v-model="passwordRepeat">
                            </div>

                            <div class="form-grid__item form-check">
                                <input  type="checkbox" class="form-check-input" id="terms" v-model="terms">
                                <label  class="form-check-label" for="terms">Acepto terminos y condiciones</label>
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
                genre: "M",
                birthDate: "",
                rut: "",
                phoneNumber: "",
                email: '',
                password: "",
                passwordRepeat: "",
                terms: ""
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
                            password: this.password
                        })
                        .then(res => {
                            alert(res.data.msg)

                            this.name = ""
                            this.genre = "M"
                            this.birthDate = ""
                            this.rut = ""
                            this.phoneNumber = ""
                            this.email = ""
                            this.password = ""
                            this.passwordRepeat = ""
                            this.terms = ""

                            window.location.href="{{ url('/') }}"

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

                return error

            },
            isNumber: function(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;

                if ((charCode > 31 && (charCode < 48 || charCode > 57))) {
                    evt.preventDefault();;
                } else {
                    return true;
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
            //this.test()
        }

    })
</script>

@endpush