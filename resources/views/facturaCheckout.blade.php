@extends('layouts.main')

@section('content')

    <div class="container pagina bg" v-cloak>

        <div class="loader-cover-custom" v-if="loading == true">
            <div class="loader-custom"></div>
        </div>

        <div class="row">
            
               <!--- <a class="btn btn-primary btn-general btn-general--form" style="color: #fff;" href="{{ url()->previous() }}"><i class="fa fa-arrow-left"></i></a>
            </div>--->
            <div class="col-12">
                <div class="title__general fadeInUp wow animated mt-5">
                    <p><strong>Factura </strong></p>
                </div>
               
            </div>
        </div>

        <div class="row mt-4 ">

            <div class="col-md-6 mb-4">
                <div>
                    <label  for="businessName">* Razón social</label>
                    <input  placeholder="Razón social" type="text" class="form-control" id="businessName" v-model="businessName">
                </div>
            </div>

            <div class="col-md-6 mb-4">

                <div>
                    <label  for="businessRut">* RUT de empresa</label>
                    <input  placeholder="RUT" type="text" class="form-control" id="businessRut" v-model="businessRut">
                </div>

            </div>

        </div>

        <div class="row ">

            <div class="col-md-6 mb-4">

                <div >
                    <label  for="businessAddress">* Dirección de la razón social</label>
                    <input  placeholder="Dirección" type="text" class="form-control" id="businessAddress" v-model="businessAddress">
                </div>
            </div>

            <div class="col-md-6 mb-4">

                <div >
                    <label  for="businessPhone">* Teléfono de contacto de razón social</label>
                    <input  placeholder="Teléfono de contacto" type="text" class="form-control" id="businessPhone" @focus="setBusinessNumber()" v-model="businessPhone">
                </div>
            </div>

        </div>

        <div class="row ">
            <div class="col-md-6 mb-4">
                <div>
                    <label  for="businessMail">* Mail de administración</label>
                    <input  placeholder="Email de adminstradción" type="text" class="form-control" id="businessMail" v-model="businessMail">
                </div>
            </div>
        </div>

        <div class="row ">
            <div class="col-12">
                <p class="text-center">
                    <button style="padding-left: 20px; padding-right: 20px;" class="btn btn-primary btn-general2" @click="factura()">Pagar</button>
                </p>
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
                    loading:false,
                    businessName:"{{ $user->business_name }}",
                    businessRut:"{{ $user->business_rut }}",
                    businessAddress:"{{ $user->business_address }}",
                    businessPhone:"{{ $user->business_phone }}",
                    businessMail:"{{ $user->business_mail }}"
                }
            },
            methods:{

                factura(){

                    axios.post("{{ url('/checkout/store-session') }}", {items: JSON.parse(localStorage.getItem("checkoutProduct")), type: "factura", businessName: this.businessName, businessRut: this.businessRut, businessAddress: this.businessAddress, businessPhone: this.businessPhone, businessMail: this.businessMail})
                    .then(res => {
                        if(res.data.success == true){
                            window.location.href = "{{ route('checkout') }}"
                        }

                    })

                },
                

            },
            mounted(){
                
                window.localStorage.removeItem("deira_store_go_to_payment")

            }

        })

    </script>

@endpush