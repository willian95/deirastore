@extends('layouts.main')

@section('content')

    <div class="container bg card-form" v-cloak>
        <div class="row">
           <!-- <div class="col-12">
                <a class="btn btn-primary btn-general btn-general--form" style="color: #fff;" href="{{ url()->previous() }}"><i class="fa fa-arrow-left"></i></a>
            </div>-->
        </div>
        <div class="row center-form">
            <div class="col-lg-4  col-md-6  col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="title__general fadeInUp wow animated">
                            <p><strong>Inicio</strong> de sesión</p>
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
                            <a href="{{ url('/register') }}">¿Aún no se registra?</a>
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
                                alertify.error(res.data.msg)
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

            }

        },
        mounted() {
            //this.test()
        }

    })
</script>

@endpush