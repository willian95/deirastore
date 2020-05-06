@extends('layouts.main')

@section('content')
    @include('partials.navbar')
    <div class="container bg card-form">
        <div class="row center-form">
            <div class="col-lg-4  col-md-6  col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="title__general">
                            <p><strong>Inicio</strong> de sesion</p>
                        </div>
                        <div class="form-group">
                            <!-- <label for="email">Email</label> -->
                            <input placeholder="Correo electrónico" type="email" autocomplete="off" class="form-control" id="email" aria-describedby="emailHelp" v-model="email">
                        </div>
                        <div class="form-group">
                            <!-- <label for="password">Clave</label> -->

                            <input placeholder="Contraseña" type="password" class="form-control fa fa-envelope" id="password" v-model="password">
                        </div>
                        <div class="form-group pass">
                            <a href="{{ url('/password/recovery') }}">¿Has olvidado tu contraseña?</a>
                        </div>
                    

                        <div class="form-group text-center">
                            <button class="btn btn-primary btn-general btn-general--form" @click="logIn()">Acceder</button>
                        </div>

<br><br>
                        <div class="form-group pass text-center" style="font-size: 1rem;
                        font-weight: 600;">
                            <a href="{{ url('/register') }}">¿Aun no se registra?</a>
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
                email: '',
                password: ""
            }
        },
        methods: {

            logIn() {

                if (!this.formHasErrors()) {

                    axios.post("{{ url('/login') }}", {
                            email: this.email,
                            password: this.password
                        })
                        .then(res => {

                            if (res.data.success == false) {
                                alert(res.data.msg)
                            } else {

                                if (res.data.user.rol_id == 1) {
                                    window.location.replace("{{ url('/') }}")
                                } else if (res.data.user.rol_id == 3) {
                                    window.location.replace("{{ route('admin.dashboard') }}")
                                }

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

                if (this.email == "") {
                    alert('Campo email es obligatorio')
                    error = true
                }

                if (this.password == "") {
                    alert('Campo clave es obligatorio')
                    error = true
                }

                return error

            }

        },
        mounted() {
            //this.test()
        }

    })
</script>

@endpush