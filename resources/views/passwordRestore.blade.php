@extends('layouts.main')

@section('content')

    @include('partials.navbar')

    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-md-6 offset-md-3 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Clave</label>
                            <input type="password" class="form-control" v-model="password">
                        </div>
                        <div class="form-group">
                            <label for="">Repetir clave</label>
                            <input type="password" class="form-control" v-model="password_confirmation">
                        </div>
                    
                        <div class="form-group">
                            <button class="btn btn-primary" @click="update()">Cambiar</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

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

                            alert(res.data.msg)
                            window.location.href="{{ url('/') }}"

                        }else{

                            alert(res.data.msg)

                        }

                    })
                    .catch(err => {
                        
                        $.each(err.response.data.errors, function(key, value){
                            alert(value)
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