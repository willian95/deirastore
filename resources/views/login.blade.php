@extends('layouts.main')

@section('content')
    @include('partials.navbar')
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-md-6 offset-md-3 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" aria-describedby="emailHelp" v-model="email">
                        </div>
                        <div class="form-group">
                            <label for="password">Clave</label>
                            <input type="password" class="form-control" id="password" v-model="password">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" @click="logIn()">Log In</button>
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
                    email:'',
                    password:""
                }
            },
            methods:{
                
                logIn(){
                    
                    if(!this.formHasErrors()){

                        axios.post("{{ url('/login') }}", {email: this.email, password: this.password})
                        .then(res => {

                            if(res.data.success == false){
                                alert(res.data.msg)
                            }else{

                                if(res.data.user.rol_id == 1){
                                    window.location.replace("{{ url('/') }}")
                                }else if(res.data.user.rol_id == 3){
                                    window.location.replace("{{ route('admin.dashboard') }}")
                                }

                            }

                        })
                        .catch(err => {
                            $.each(err.response.data.errors, function(key, value){
                                alert(value)
                            });
                        })

                    }

                },
                formHasErrors(){

                    let error = false

                    if(this.email == ""){
                        alert('Campo email es obligatorio')
                        error = true
                    }

                    if(this.password == ""){
                        alert('Campo clave es obligatorio')
                        error = true
                    }

                    return error

                }

            },
            mounted(){
                //this.test()
            }

        })

    </script>

@endpush