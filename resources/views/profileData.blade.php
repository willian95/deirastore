@extends('layouts.main')

@section('content')

    <div class="container bg card-form" v-cloak>
       <!--- <div class="row">
            <div class="col-12">
                <a class="btn btn-primary btn-general btn-general--form" style="color: #fff;" href="{{ url()->previous() }}"><i class="fa fa-arrow-left"></i></a>
            </div>
        </div>--->
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-md-8 offset-md-2 col-12">
                
                <div class="">
                    <div class="card-body">
                        <div class="title__general2 fadeInUp wow animated pag-center">
                            <strong class="mr-5 mr-auto"> <p>Perfil</p></strong> 

                            <div class="form-group text-center">
                                <button class="btn btn-primary btn-general2 pl-4 pr-4" @click="edit()" v-if="readonly == true">Editar</button>
                                <button class="btn btn-primary btn-general2" @click="cancelEdit()" v-if="readonly == false">Cancelar edición</button>
                                <button class="btn btn-primary btn-general2" @click="update()" v-if="readonly == false">Actualizar</button>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name">Nombre</label>
                                    <input type="text" class="form-control" id="name" aria-describedby="emailHelp" v-model="name" :readonly="readonly">
                                </div>
                                <div class="col-md-6">
                                    <label for="name">Apellido</label>
                                    <input type="text" placeholder="Apellido" class="form-control" aria-describedby="emailHelp" v-model="lastname" :readonly="readonly">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label >* Región</label>
                                    <select class="form-control" v-model="location" @change="regionChange()" :disabled="readonly">
                                        @foreach(App\Region::all() as $region)
                                            <option :value="{{ $region->id }}">{{ $region->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label  for="comuna">* Comuna</label>
                                    <select class="form-control" v-model="selectedComune" :disabled="readonly">
                                        
                                        <option v-for="comune in communes" :value="comune.id">@{{ comune.name }}</option>
                                        
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label  for="street">* Calle</label>
                                    <input  placeholder="Ingresa nombre de la calle" type="text" class="form-control" id="street" v-model="street" :disabled="readonly">
                                </div>
                                <div class="col-md-6">
                                    <label  for="number">* Número</label>
                                    <input  placeholder="Ingresa número" type="text" class="form-control" id="number" v-model="number" :disabled="readonly">
                                </div>
                            </div>
                        </div>
                        <div class="form-grid__itm col-md-12">
                            <label  for="house">Dpto. / Casa / Oficna (Opcional)</label>
                            <input  placeholder="Ingresa número" type="text" class="form-control" id="house" v-model="house" :disabled="readonly">
                        </div>


                        
                            
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="rut">RUT</label>
                                    <input type="text" class="form-control" id="rut" aria-describedby="rut" v-model="rut" :disabled="readonly">
                                </div>
                                <div class="col-md-6">
                                    <label for="genre">Género</label>
                                    <select class="form-control" id="genre" v-model="genre" :disabled="readonly">
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
                                    <input type="date" class="form-control" id="birthDate" aria-describedby="emailHelp" v-model="birthDate" :disabled="readonly">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phoneNumber">Celular</label>
                                        <input type="text" class="form-control" id="phoneNumber" aria-describedby="emailHelp" @focus="setNumber()" v-model="phoneNumber" @keypress="isTelephoneNumber($event)" :disabled="readonly">
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="password">Clave</label>
                                    <input type="password" class="form-control" id="password" v-model="password" :disabled="readonly">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="passwordRepeat">Repetir Clave</label>
                                        <input type="password" class="form-control" id="passwordRepeat" v-model="passwordRepeat" :disabled="readonly">
                                    </div>
                                </div>
                            </div>
                        </div>

                    
                            <div class="row" style="width: 100%">
                                <div class="col-12">
                                    
                                    <div class="form-grid__item form-check">
                                        <input  type="checkbox" class="form-check-input mt-2" id="showBusiness" v-model="showBusiness" :disabled="readonly">
                                        <label  class="form-check-label mt-3" for="showBusiness"><h3 class="text-center">Empresa</h3></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4 ">

                                <div class="col-md-6 mb-4">
                                    <div  v-if="showBusiness == true">
                                        <label  for="businessName">* Razón social</label>
                                        <input  placeholder="Razón social" type="text" class="form-control" id="businessName" v-model="businessName" :disabled="readonly">
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">

                                    <div  v-if="showBusiness == true">
                                        <label  for="businessRut">* RUT de empresa</label>
                                        <input  placeholder="RUT" type="text" class="form-control" id="businessRut" v-model="businessRut" :disabled="readonly">
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-6 mb-4">

                                    <div  v-if="showBusiness == true">
                                        <label  for="businessAddress">* Dirección de la razón social</label>
                                        <input  placeholder="Dirección" type="text" class="form-control" id="businessAddress" v-model="businessAddress" :disabled="readonly">
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">

                                    <div  v-if="showBusiness == true">
                                        <label  for="businessPhone">* Teléfono de contacto de razón social</label>
                                        <input  placeholder="Teléfono de contacto" type="text" class="form-control" id="businessPhone" @focus="setBusinessNumber()" v-model="businessPhone" :disabled="readonly">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div  v-if="showBusiness == true">
                                        <label  for="businessMail">* Mail de adminsitración</label>
                                        <input  placeholder="Email de adminstradción" type="text" class="form-control" id="businessMail" v-model="businessMail" :disabled="readonly">
                                    </div>
                                </div>
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
                    showBusiness:false,
                    businessName:"{!! Auth::user()->business_name !!}",
                    businessRut:"{!! Auth::user()->business_rut !!}",
                    businessAddress:"{!! Auth::user()->business_address !!}",
                    businessPhone:"{!! Auth::user()->business_phone !!}",
                    businessMail:"{!! Auth::user()->business_mail !!}",
                    communes:[],
                    password:"",
                    passwordRepeat:"",
                    readonly:true

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
                        formData.append("street", this.street)
                        formData.append("location", this.location)
                        formData.append("number", this.number)
                        formData.append("comune_id", this.selectedComune)
                        formData.append("showBusiness", this.showBusiness)
                        formData.append("businessName", this.businessName)
                        formData.append("businessRut", this.businessRut)
                        formData.append("businessAddress", this.businessAddress)
                        formData.append("businessPhone", this.businessPhone)
                        formData.append("businessMail", this.businessMail)

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
                                alertify.error(value[0])
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

                    if(this.showBusiness == true && this.businessRut == ""){
                        alertify.error("RUT de empresa es requerido")
                        error = true
                    }

                    if(this.showBusiness == true && this.businessAddress == ""){
                        alertify.error("Dirección de empresa es requerida")
                        error = true
                    }

                    if(this.showBusiness == true && this.businessPhone == ""){
                        alertify.error("Teléfono de empresa es requerido")
                        error = true
                    }else if(this.showBusiness == true && this.businessPhone != ""){
                        let regexp = /^(\+?56)?(\s?)(\s?)[9876543]\d{7}$/
                        if(this.businessPhone.match(regexp)){
                        
                        }else{
                            alertify.error("Número telefónico no válido")
                            error = true
                        }
                    }

                    if(this.showBusiness == true && this.businessMail == ""){
                        alertify.error("Email de empresa es requerido")
                        error = true
                    }else if(this.showBusiness == true && this.businessMail != ""){

                        const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                        if(re.test(this.businessMail)){

                        }else{
                            alertify.error("Email no válido")
                            error = true
                        }

                    }

                    return error

                },
                setNumber(){

                    if(this.phoneNumber == ""){
                        this.phoneNumber = "+569"
                    }

                },
                setBusinessNumber(){

                    if(this.businessPhone == ""){
                        this.businessPhone = "+569"
                    }

                },
                regionChange(){

                    axios.get("{{ url('/comune/by-region') }}"+"/"+this.location).then(res =>{
                        //console.log("test-region-change", res)
                        if(res.data.success == true){
                            this.communes = res.data.comunes
                        }
                    })

                },
                edit(){
                    this.readonly = false
                },
                cancelEdit(){
                    this.readonly = true
                }

            },
            created(){
                
                this.regionChange()
                if("{!! Auth::user()->business_name !!}" != ""){
                    this.showBusiness == true
                }
                
                //this.test()
            }

        })
    
    </script>

@endpush