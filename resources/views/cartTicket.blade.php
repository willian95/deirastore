@extends('layouts.main')

@section('content')

    <div class="container pagina bg">

        <div class="row">
            <div class="col-12">
                <a class="btn btn-primary btn-general btn-general--form" style="color: #fff;" href="{{ url()->previous() }}"><i class="fa fa-arrow-left"></i></a>
            </div>
            <div class="col-12">
                <h2 class="text-center">Tipo de Facturación</h2>
            </div>

            <div class="col-6">
                <p class="text-center">
                    <button class="btn btn-success" @click="boleta()">Boleta</button>
                </p>
            </div>
            @if(\Auth::check())
                <div class="col-6">
                    <p class="text-center">
                        <button class="btn btn-success" @click="factura()">Factura</button>
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