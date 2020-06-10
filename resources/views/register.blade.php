@extends("layouts.main")

@section('content')

    <div class="container bg card-form">
      <!---  <div class="row">
            <div class="col-12">
                <a class="btn btn-primary btn-general btn-general--form" style="color: #fff;" href="{{ url()->previous() }}"><i class="fa fa-arrow-left"></i></a>
            </div>
        </div>--->
        <div class="row center-form">
            <div class="col-lg-6  col-md-6  col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="title__general fadeInUp wow animated">
                            <p><strong>Registro</strong> de usuario </p>
                        </div>

                        <div class="form-grid">
                            <!-- input -->
                            <div class="form-grid__item">
                                <label  for="name">* Nombre</label>
                                <input  placeholder="Ej: Pedro" type="text" class="form-control" id="name" aria-describedby="emailHelp" v-model="name">
                            </div>
                            <!-- input -->
                            <div class="form-grid__item">
                                <label  for="name">* Apellido</label>
                                <input  placeholder="Ej: Perez " type="text" class="form-control" aria-describedby="emailHelp" v-model="lastname">
                            </div>
                            <!-- input -->
                            <div class="form-grid__item">
                                <label  for="genre">* Género</label>
                                <select class="form-control" id="genre" v-model="genre">
                                    <option>Género</option>
                                    <option value="masculino">Masculino</option>
                                    <option value="femenino">Femenino</option>
                                    <option value="prefiero mantenerlo en privado">Prefiero mantenerlo en privado</option>
                                </select>
                            </div>
                            <!-- input -->
                            <div class="form-grid__item">
                                <label  for="birthDate">* Fec. Nacimiento</label>
                                <input  placeholder="Fec. Nacimiento " type="date" class="form-control" id="birthDate" aria-describedby="emailHelp" v-model="birthDate">
                            </div>
                                <!-- input -->
                                <div class="form-grid__item inputcontainer">
                                    <label  for="rut">* Rut</label>
                                    <input placeholder="Ej: 121456789" type="text" class="form-control" id="rut" aria-describedby="emailHelp" v-model="rut" @keypress="isAlphaNumeric($event)" @blur="validateRut()">
                                    <div class="icon-container" v-if="loading == true">
                                        <i class="loader"></i>
                                    </div>
                                    <div class="icon-container" v-if="loading == false && isRutValid == true">
                                        <i class="fa fa-check-square"></i>
                                    </div>
                                    <div class="icon-container" v-if="loading == false && isRutValid == false">
                                        <i class="fa fa-times"></i>
                                    </div>
                                </div>
                                    <!-- input -->
                        
                                <!-- input -->
                                <div class="form-grid__item">
                                    <label  for="phoneNumber">* Celular</label>
                                    <input  placeholder="Ej: +56933123123" type="text" class="form-control" id="phoneNumber" aria-describedby="emailHelp" v-model="phoneNumber" @keypress="isTelephoneNumber($event)" @focus="setNumber()">
                                </div>
                                    <!-- input -->
                            <div class="form-grid__item">
                                <label  for="email">* Email</label>
                                <input  placeholder="Ej: email@gmail.com " type="email" class="form-control" id="email" aria-describedby="emailHelp" v-model="email">
                            </div>
                            <div class="form-grid__item">
                                <label  for="password">* Contraseña</label>
                                <input  placeholder="Contraseña " type="password" class="form-control" id="password" v-model="password">
                            </div>

                            <div class="form-grid__item">
                                <label  for="passwordRepeat">* Repetir Contraseña</label>
                                <input  placeholder="Repetir Contraseña " type="password" class="form-control" id="passwordRepeat" v-model="passwordRepeat">
                            </div>
                            <div class="form-grid__item">
                                <label >* Región</label>
                                <select class="form-control" v-model="location" @change="regionChange()">
                                    @foreach(App\Region::all() as $region)
                                        <option :value="{{ $region->id }}">{{ $region->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-grid__item">
                                <label  for="comuna">* Comuna</label>
                                <select class="form-control" v-model="selectedComune">
                                   
                                    <option v-for="comune in communes" :value="comune.id">@{{ comune.name }}</option>
                                    
                                </select>
                            </div>
                            <div class="form-grid__item">
                                <label  for="street">* Calle</label>
                                <input  placeholder="Ingresa nombre de la calle" type="text" class="form-control" id="street" v-model="street">
                            </div>
                            <div class="form-grid__item">
                                <label  for="number">* Número</label>
                                <input  placeholder="Ingresa número" type="text" class="form-control" id="number" v-model="number">
                            </div>
                            <div class="form-grid__item">
                                <label  for="house">Dpto. / Casa / Oficna (Opcional)</label>
                                <input  placeholder="Ingresa número" type="text" class="form-control" id="house" v-model="house">
                            </div>

                            <div class="row" style="width: 100%">
                                <div class="col-12">
                                    
                                    <div class="form-grid__item form-check">
                                        <input  type="checkbox" class="form-check-input mt-2" id="showBusiness" v-model="showBusiness">
                                        <label  class="form-check-label mt-3" for="showBusiness"><h3 class="text-center">Empresa</h3></label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-grid__item" v-if="showBusiness == true">
                                <label  for="businessName">* Razón social</label>
                                <input  placeholder="Razón social" type="text" class="form-control" id="businessName" v-model="businessName">
                            </div>

                            <div class="form-grid__item" v-if="showBusiness == true">
                                <label  for="businessRut">* RUT de empresa</label>
                                <input  placeholder="RUT" type="text" class="form-control" id="businessRut" v-model="businessRut">
                            </div>

                            <div class="form-grid__item" v-if="showBusiness == true">
                                <label  for="businessAddress">* Dirección de la razón social</label>
                                <input  placeholder="Dirección" type="text" class="form-control" id="businessAddress" v-model="businessAddress">
                            </div>

                            <div class="form-grid__item" v-if="showBusiness == true">
                                <label  for="businessPhone">* Teléfono de contacto de razón social</label>
                                <input  placeholder="Teléfono de contacto" type="text" class="form-control" id="businessPhone" v-model="businessPhone">
                            </div>

                            <div class="form-grid__item" v-if="showBusiness == true">
                                <label  for="businessMail">* Mail de adminsitración</label>
                                <input  placeholder="Email de adminstradción" type="text" class="form-control" id="businessMail" v-model="businessMail">
                            </div>

                            <div class="form-grid__item form-check" style="visibility: hidden" v-if="showBusiness == true">
                                <input  type="checkbox" class="form-check-input mt-2" >
                                <label  class="form-check-label mt-3" for="terms">Acepto terminos y condiciones</label>
                            </div>

                            <div class="form-grid__item">
                                {!! htmlFormSnippet() !!}
                            </div>

                            <div class="form-grid__item form-check" style="visibility: hidden">
                                <input  type="checkbox" class="form-check-input mt-2" >
                                <label  class="form-check-label mt-3" for="terms">Acepto terminos y condiciones</label>
                            </div>

                            
                            <div class="form-grid__item form-check">
                                <input  type="checkbox" class="form-check-input mt-2" id="terms" v-model="terms">
                                <label  class="form-check-label mt-3" for="terms"><a href="{{ url('/terms') }}" target="_blank">Acepto terminos y condiciones</a></label>
                            </div>

                            
                         
                            <div class="form-grid__item mt-5 mb-3"> </div>
                            <div class="form-grid__item">
                                <div class="form-group text-center">
                                    <button class="btn btn-primary btn-general btn-general--form" @click="register()">Registrar</button>
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
        data() {
            return {
                name: "",
                isRutValid:false,
                lastname:"",
                genre: "masculino",
                birthDate: "",
                rut: "",
                street:"",
                house:"",
                phoneNumber: "",
                email: '',
                password: "",
                passwordRepeat: "",
                terms: "",
                location:"",
                loading:false,
                reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
                captchaResponse:"",
                communes:[],
                selectedComune:"",
                house:"",
                number:"",
                businessName:"",
                businessRut:"",
                businessAddress:"",
                businessPhone:"",
                businessMail:"",
                showBusiness:false

            }
        },
        methods: {

            register() {
                this.captchaResponse = $("#g-recaptcha-response").val()
                if (!this.formHasErrors()) {
                    
                    axios.post("{{ url('/register') }}", {
                            name: this.name,
                            genre: this.genre,
                            birthDate: this.birthDate,
                            rut: this.rut,
                            phoneNumber: this.phoneNumber,
                            email: this.email,
                            password: this.password,
                            lastname: this.lastname,
                            street: this.street,
                            recaptcha: this.captchaResponse,
                            location: this.location,
                            comune_id: this.selectedComune,
                            house: this.house,
                            number: this.number,
                            showBusiness: this.showBusiness,
                            businessName: this.businessName,
                            businessRut:this.businessRut,
                            businessAddress:this.businessAddress,
                            businessPhone:this.businessPhone,
                            businessMail:this.businessMail,
                        })
                        .then(res => {
                            
                            if(res.data.success == true){
 
                                swal({
                                    icon: "success",
                                    title: res.data.msg,
                                    text:"Revise su correo"
                                })

                                this.name = ""
                                this.genre = "masculino"
                                this.birthDate = ""
                                this.rut = ""
                                this.phoneNumber = ""
                                this.email = ""
                                this.password = ""
                                this.passwordRepeat = ""
                                this.lastname = ""
                                this.terms = "",
                                this.stree = ""
                                this.location = ""
                                this.comune_id = ""
                                this.house = ""
                                this.number = ""

                                window.setTimeout(() => {
                                    window.location.href="{{ url('/') }}"
                                }, 5000);
                                
                            }else{

                                swal({
                                    icon: "error",
                                    title: "Error",
                                    text: res.data.msg
                                    
                                })

                                grecaptcha.reset();

                            }

                        })
                        .catch(err => {
                            $.each(err.response.data.errors, function(key, value) {
                                alertify.error(value[0])
                            });
                        })
                        
                }

            },
            formHasErrors() {

                let error = false

                if (this.name == "") {
                    alertify.error("Campo nombre es requerido")
                    error = true
                }

                if (this.lastname == "") {
                    alertify.error("Campo apellido es requerido")
                    error = true
                }

                if (this.genre == "") {
                    alertify.error("Campo genero es requerido")
                    error = true
                }

                if (this.birthDate == "") {
                    alertify.error("Campo fecha de nacimiento es requerido")
                    error = true
                }

                if (this.rut == "") {
                    alertify.error("Campo rut es requerido")
                    error = true
                }

                if (this.phoneNumber == "") {
                    alertify.error("Campo celular es requerido")
                    error = true

                }else{
                    let regexp = /^(\+?56)?(\s?)(0?9)(\s?)[9876543]\d{7}$/
                    //let regexp = /^(\+?56)?(\s?)(\s?)[9876543]\d{7}$/
                    if(this.phoneNumber.match(regexp)){
                    
                    }else{
                        alertify.error("Número telefónico no válido")
                        error = true
                    }

                }

                if (this.email == "") {
                    alertify.error("Campo email es requerido")
                    error = true
                }

                if (this.password == "") {
                    alertify.error("Campo clave es requerido")
                    error = true
                }

                if (this.password == "") {
                    alertify.error("Campo repetir clave es requerido")
                    error = true
                }

                if (this.password != this.passwordRepeat) {
                    alertify.error("Claves no coinciden")
                    error = true
                }

                if (this.terms == false) {
                    alertify.error("Debe aceptar los terminos y condiciones")
                    error = true
                }

                if(this.isRutValid == false){
                    alertify.error("Rut no válido")
                    error = true
                }

                if(!this.reg.test(this.email)){
                    alertify.error("Email no válido")
                    error = true
                }

                if(this.showBusiness == true && this.businessName == ""){
                    alertify.error("Razón social es requerida")
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
            isNumber: function(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;

                if ((charCode > 31 && (charCode < 48 || charCode > 57))) {
                    evt.preventDefault();
                } else {
                    return true;
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
            isAlphaNumeric(evt){

                evt = (evt) ? evt : window.event;

                var letters = /^[0-9a-zA-Z]+$/;
                if(evt.key.match(letters))
                {
                    return true;
                }
                else
                {
                    evt.preventDefault();
                }

            },
            isTelephoneNumber: function(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;

                if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 43) {
                    evt.preventDefault();;
                } else {
                    return true;
                }
            },
            setNumber(){

                if(this.phoneNumber == ""){
                    this.phoneNumber = "+569"
                }

            },
            validateRut(){
               
                if(this.rut != ""){
                    this.loading = true
                    axios.get("{{ url('/validate/rut/') }}"+"/"+this.rut).then(res => {
                        this.loading = false
                        if(res.data.success == true){

                            this.isRutValid = res.data.data
                            
                        }else{
                            this.isRutValid = res.data.data
                            alertify.error(res.data.msg)

                        }

                    })
                    .catch(err => {

                    })
                }
                
            }

        },
        mounted() {
            //this.test()
        }

    })
</script>

@endpush