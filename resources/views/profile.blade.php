@extends('layouts.main')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <a class="btn btn-primary btn-general btn-general--form" style="color: #fff;" href="{{ url()->previous() }}"><i class="fa fa-arrow-left"></i></a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-md-8 offset-md-2 col-12">
                
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center">Perfil</h3>

                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" id="name" aria-describedby="emailHelp" v-model="name">
                        </div>

                        <div class="form-group">
                            <label for="rut">RUT</label>
                            <input type="text" class="form-control" id="rut" aria-describedby="rut" v-model="rut">
                        </div>

                        <div class="form-group">
                            <label for="name">Apellido</label>
                            <input type="text" class="form-control" aria-describedby="emailHelp" v-model="lastname">
                        </div>

                        <div class="form-group">
                            <label for="genre">Género</label>
                            <select class="form-control" id="genre" v-model="genre">
                                <option value="masculino">Masculino</option>
                                <option value="femenino">Femenino</option>
                                <option value="prefiero mantenerlo en privado">Prefiero mantenerlo en privado</option>
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

    @include('partials.footer')

@endsection

@push('scripts')
    
    <script>
        
        const app = new Vue({
            el: '#dev-app',
            data(){
                return{
                    name: "{!! Auth::user()->name !!}",
                    lastname: '{!! Auth::user()->lastname !!}',
                    genre: "{!! Auth::user()->genre !!}",
                    birthDate: "{!! Auth::user()->birth_date !!}",
                    phoneNumber: "{!! Auth::user()->phone_number !!}",
                    rut:"{!! Auth::user()->rut !!}",
                    address:"{!! Auth::user()->address !!}",
                    password:"",
                    passwordRepeat:""

                }
            },
            methods:{

                update(){

                    if(!this.formHasError()){

                        let formData = new FormData()
                        formData.append("name", this.name)
                        formData.append("lastname", this.lastname)
                        formData.append("genre", this.genre)
                        formData.append("birthDate", this.birthDate)
                        formData.append("phoneNumber", this.phoneNumber)
                        formData.append("password", this.password)
                        formData.append("passwordRepeat", this.passwordRepeat)
                        formData.append("rut", this.rut)
                        formData.append("address", this.address)

                        axios.post("{{ route('profile.update') }}", formData)
                        .then(res => {

                            if(res.data.success == true){
                                
                                alertify.success(res.data.msg)
                                this.password = ""
                                this.passwordRepeat = ""
                            
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
                formHasError(){

                    let error = false

                    if(this.name == ""){
                        alertify.error('Campo nombre es requerido')
                        error = true
                    }

                    if(this.genre == ""){
                        alertify.error('Campo genero es requerido')
                        error = true
                    }

                    if(this.birthDate == ""){
                        alertify.error('Campo fecha de nacimiento es requerido')
                        error = true
                    }

                    if(this.phoneNumber == ""){
                        alertify.error('Campo numero de telefono es requerido')
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