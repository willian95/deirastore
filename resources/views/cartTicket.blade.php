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
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                            <button class="btn btn-primary btn-general btn-general--form" @click="logIn()">Login</button>
                        </div>

                        <h5 class="text-center">¿Aún no tienes cuenta?</h5>
                        <div class="form-group text-center mb-5 mt-3">
                            <button class="btn btn-primary btn-general btn-general--form">Registrate</button>
                        </div>


                        <div class="col-12">
                            <div style="display:flex;">
                                <a href="{{ url('auth/google?path=/cart/ticket') }}" class="btn btn-success">Google</a>
                                <button class="btn btn-success">Facebook</button>
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
                    email:"",
                    password:""
                }
            },
            methods:{
                
                boleta(){

                    /*localStorage.setItem("bill_type", "boleta")

                    axios.post("{{ url('/checkout/store-session') }}", {items: JSON.parse(localStorage.getItem("checkoutProduct")), type: "boleta", guestUser: JSON.parse(localStorage.getItem("guestUser"))})
                    .then(res => {

                        if(res.data.success == true){
                            window.location.href = "{{ route('checkout') }}"
                        }

                    })*/

                },
                factura(){

                    localStorage.setItem("bill_type", "factura")
                    axios.post("{{ url('/checkout/store-session') }}", {items: JSON.parse(localStorage.getItem("checkoutProduct")), type: "factura"})
                    .then(res => {
                        if(res.data.success == true){
                            window.location.href = "{{ route('checkout') }}"
                        }

                    })

                }

            },
            mounted(){
                this.authCheck = "{{ \Auth::check() }}"
            }

        })

    </script>

@endpush