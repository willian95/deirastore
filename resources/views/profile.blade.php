@extends('layouts.main')

@section('content')

    @include('partials.navbar')

    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-md-8 offset-md-2 col-12">
                
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center">Perfil</h3>

                        <div class="form-group">
                            <label for="name">Nombre Completo</label>
                            <input type="text" class="form-control" id="name" aria-describedby="emailHelp" v-model="name">
                        </div>

                        <div class="form-group">
                            <label for="genre">Género</label>
                            <select class="form-control" id="genre" v-model="genre">
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="birthDate">Fec. Nacimiento</label>
                            <input type="date" class="form-control" id="birthDate" aria-describedby="emailHelp" v-model="birthDate">
                        </div>
                        <div class="form-group">
                            <label for="phoneNumber">Celular</label>
                            <input type="text" class="form-control" id="phoneNumber" aria-describedby="emailHelp" v-model="phoneNumber" @keypress="isTelephoneNumber($event)">
                        </div>
                        <div class="form-group">
                            <label for="password">Clave</label>
                            <input type="password" class="form-control" id="password" v-model="password">
                        </div>
                        <div class="form-group">
                            <label for="passwordRepeat">Repetir Clave</label>
                            <input type="password" class="form-control" id="passwordRepeat" v-model="passwordRepeat">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" @click="update()">Actualizar</button>
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
                    name: "{!! Auth::user()->name !!}",
                    genre: "{!! Auth::user()->genre !!}",
                    birthDate: "{!! Auth::user()->birth_date !!}",
                    phoneNumber: "{!! Auth::user()->phone_number !!}",
                    password:"",
                    passwordRepeat:""

                }
            },
            methods:{

                update(){

                    if(!this.formHasError()){

                        let formData = new FormData()
                        formData.append("name", this.name)
                        formData.append("genre", this.genre)
                        formData.append("birthDate", this.birthDate)
                        formData.append("phoneNumber", this.phoneNumber)
                        formData.append("password", this.password)
                        formData.append("passwordRepeat", this.passwordRepeat)

                        axios.post("{{ route('profile.update') }}", formData)
                        .then(res => {

                            if(res.data.success == true){
                                
                                alert(res.data.msg)
                                this.password = ""
                                this.passwordRepeat = ""
                            
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
                formHasError(){

                    let error = false

                    if(this.name == ""){
                        alert('Campo nombre es requerido')
                        error = true
                    }

                    if(this.genre == ""){
                        alert('Campo genero es requerido')
                        error = true
                    }

                    if(this.birthDate == ""){
                        alert('Campo fecha de nacimiento es requerido')
                        error = true
                    }

                    if(this.phoneNumber == ""){
                        alert('Campo numero de telefono es requerido')
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