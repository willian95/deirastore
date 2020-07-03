@extends('layouts.main')

@section('content')

 
    <div class="container bg card-form" v-cloak>
        <div class="row center-form">
            <div class="col-lg-4  col-md-6  col-12">
                <div class="card">
                    <div class="card-body">
                    <div class="title__general title__general--font">
                        <p><strong>Recuperar</strong> contraseña</p>
                    </div>
                        <div class="form-group">
                            <!-- <label for="email">Email</label> -->
                            <input placeholder="Correo electrónico"  type="email" class="form-control" id="email" aria-describedby="emailHelp" v-model="email">
                        </div>
                    
                        <div class="form-group text-center">
                            <button class="btn btn-primary btn-general btn-general--form" @click="recovery()">Recuperar</button>
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
                    email:''
                }
            },
            methods:{
                
                recovery(){
                    
                    axios.post("{{ url('/password/recovery/send') }}", {email: this.email})
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