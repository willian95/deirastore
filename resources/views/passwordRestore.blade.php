@extends('layouts.main')

@section('content')

    <div class="container bg card-form" v-cloak>
        <div class="row center-form">
            <div class="col-lg-4  col-md-6  col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <!-- <label for="">Clave</label> -->
                            <input placeholder="Contraseña" type="password" class="form-control" v-model="password">
                        </div>
                        <div class="form-group">
                            <!-- <label for="">Repetir clave</label> -->
                            <input placeholder="Repetir clave" type="password" class="form-control" v-model="password_confirmation">
                        </div>
                    
                        <div class="form-group text-center">
                            <button class="btn btn-primary btn-general btn-general--form" @click="update()">Cambiar</button>
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
            data(){
                return{
                    password:"",
                    password_confirmation:"",
                    recovery_hash:"{!! $recovery_hash !!}"
                }
            },
            methods:{

                update(){

                    let formData = new FormData()
                    formData.append("password", this.password)
                    formData.append("password_confirmation", this.password_confirmation)
                    formData.append("recovery_hash", this.recovery_hash)

                    axios.post("{{ url('/password/recovery/update') }}", formData)
                    .then(res => {

                        if(res.data.success == true){

                            alertify.success(res.data.msg)
                            window.location.href="{{ url('/') }}"

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
            mounted(){
                //this.test()
            }

        })

    </script>
    

@endpush