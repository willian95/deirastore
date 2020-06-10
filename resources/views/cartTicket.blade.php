@extends('layouts.main')

@section('content')

    <div class="container pagina bg">

        <div class="row">
            <div class="col-12">
               <!--- <a class="btn btn-primary btn-general btn-general--form" style="color: #fff;" href="{{ url()->previous() }}"><i class="fa fa-arrow-left"></i></a>
            </div>--->
            <div class="col-12">
                <div class="title__general fadeInUp wow animated mt-5">
                    <p><strong>Tipo de  </strong>  Facturación</p>
                </div>
               
            </div>

            <div class="col-6">
                <p class="text-center">
                    <button class="btn btn-success btn-general2 pl-4 pr-4" @click="boleta()">Boleta</button>
                </p>
            </div>
            @if(\Auth::check() && \Auth::user()->business_name != "" && \Auth::user()->business_rut != "")
                <div class="col-6">
                    <p class="text-center">
                        <button class="btn btn-success btn-general2 pl-4 pr-4 btn-general2_bg" @click="factura()">Factura</button>
                    </p>
                    <p class="text-center">
                        {{ App\Text::where("site_location", "Tipo de facturación")->where("type", "texto")->first()->text }}
                    </p>
                </div>
            @endif

        </div>

    </div>

@endsection

@push("scripts")

    <script>

        const app = new Vue({
            el: '#dev-app',
            data(){
                return{
                    
                }
            },
            methods:{
                
                boleta(){

                    localStorage.setItem("bill_type", "boleta")

                    axios.post("{{ url('/checkout/store-session') }}", {items: JSON.parse(localStorage.getItem("checkoutProduct")), type: "boleta", guestUser: JSON.parse(localStorage.getItem("guestUser"))})
                    .then(res => {

                        if(res.data.success == true){
                            window.location.href = "{{ route('checkout') }}"
                        }

                    })

                },
                factura(){

                    localStorage.setItem("bill_type", "factura")
                    axios.post("{{ url('/checkout/store-session') }}", {items: JSON.parse(localStorage.getItem("checkoutProduct")), type: "factura"})
                    .then(res => {
                        if(res.data.success == true){
                            window.location.href = "{{ route('checkout') }}"
                        }

                    })

                }

            },
            mounted(){
               
            }

        })

    </script>

@endpush