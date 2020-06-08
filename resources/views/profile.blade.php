@extends('layouts.main')

@section('content')

    <div class="container bg card-form">
       <!--- <div class="row">
            <div class="col-12">
                <a class="btn btn-primary btn-general btn-general--form" style="color: #fff;" href="{{ url()->previous() }}"><i class="fa fa-arrow-left"></i></a>
            </div>
        </div>--->
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-md-8 offset-md-2 col-12">
                
                <div class="">
                    <div class="card-body">
                        <div class="title__general fadeInUp wow animated">
                            <p ></p><strong class="mr-5">Perfil</strong> </p>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name">Nombre</label>
                                    <input type="text" class="form-control" id="name" aria-describedby="emailHelp" v-model="name">
                                </div>
                                <div class="col-md-6">
                                    <label for="name">Apellido</label>
                                    <input type="text" placeholder="Apellido" class="form-control" aria-describedby="emailHelp" v-model="lastname">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label >* Región</label>
                                    <select class="form-control" v-model="location" @change="regionChange()">
                                        @foreach(App\Region::all() as $region)
                                            <option :value="{{ $region->id }}">{{ $region->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label  for="comuna">* Comuna</label>
                                    <select class="form-control" v-model="selectedComune">
                                        
                                        <option v-for="comune in communes" :value="comune.id">@{{ comune.name }}</option>
                                        
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label  for="street">* Calle</label>
                                    <input  placeholder="Ingresa nombre de la calle" type="text" class="form-control" id="street" v-model="street">
                                </div>
                                <div class="col-md-6">
                                    <label  for="number">* Número</label>
                                    <input  placeholder="Ingresa número" type="text" class="form-control" id="number" v-model="number">
                                </div>
                            </div>
                        </div>
                        <div class="form-grid__item">
                            <label  for="house">Dpto. / Casa / Oficna (Opcional)</label>
                            <input  placeholder="Ingresa número" type="text" class="form-control" id="house" v-model="house">
                        </div>


                        
                            
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="rut">RUT</label>
                                    <input type="text" class="form-control" id="rut" aria-describedby="rut" v-model="rut">
                                </div>
                                <div class="col-md-6">
                                    <label for="genre">Género</label>
                                    <select class="form-control" id="genre" v-model="genre">
                                        <option value="masculino">Masculino</option>
                                        <option value="femenino">Femenino</option>
                                        <option value="prefiero mantenerlo en privado">Prefiero mantenerlo en privado</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                      <!--  <div class="form-group">
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
                        </div>-->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="birthDate">Fec. Nacimiento</label>
                                    <input type="date" class="form-control" id="birthDate" aria-describedby="emailHelp" v-model="birthDate">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phoneNumber">Celular</label>
                                        <input type="text" class="form-control" id="phoneNumber" aria-describedby="emailHelp" v-model="phoneNumber" @keypress="isTelephoneNumber($event)">
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="password">Clave</label>
                                    <input type="password" class="form-control" id="password" v-model="password">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="passwordRepeat">Repetir Clave</label>
                                        <input type="password" class="form-control" id="passwordRepeat" v-model="passwordRepeat">
                                    </div>
                                </div>
                            </div>
                        </div>
                     
                        <div class="form-group text-center">
                            <button class="btn btn-primary btn-general" @click="update()">Actualizar</button>
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
                    location:"{!! Auth::user()->location_id !!}",
                    selectedComune:"{!! Auth::user()->comune_id !!}",
                    street:"{!! Auth::user()->street  !!}",
                    number:"{!! Auth::user()->number !!}",
                    house:"{!! Auth::user()->house !!}",
                    communes:[],
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

                },
                regionChange(){

                    axios.get("{{ url('/comune/by-region') }}"+"/"+this.location).then(res =>{
                        //console.log("test-region-change", res)
                        if(res.data.success == true){
                            this.communes = res.data.comunes
                        }
                    })

                }

            },
            created(){
                
                this.regionChange()

                
                //this.test()
            }

        })
    
    </script>

@endpush