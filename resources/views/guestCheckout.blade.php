@extends('layouts.main')

@section('content')

    <div class="container bg card-form">
        <div class="row center-form">
            <div class="col-lg-4  col-md-6  col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="title__general fadeInUp wow animated">
                            <p><strong>Información</strong> de usuario invitado</p>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input placeholder="Correo electrónico" type="email" autocomplete="off" class="form-control" id="email" aria-describedby="emailHelp" v-model="email">
                        </div>

                        <div class="form-group">
                            <label for="email">Nombre</label>
                            <input placeholder="Nombre" type="text" autocomplete="off" class="form-control" id="name" aria-describedby="emailHelp" v-model="name">
                        </div>

                        <div class="form-group">
                            
                            <label  for="address">Región</label>
                            <select class="form-control" v-model="location" @change="getPrice()">
                                @foreach(App\Location::all() as $location)
                                    <option :value="{{ $location->id }}">{{ $location->name }}</option>
                                @endforeach
                            </select>
                        
                        </div>

                        <div class="form-group">
                            <label for="address">Dirección</label>
                            <input placeholder="Dirección" type="text" autocomplete="off" class="form-control" id="address" aria-describedby="emailHelp" v-model="address">
                        </div>
                        
                        <div class="form-group">
                            <h3>Total: $ @{{ parseInt(totalGuest).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</h3>
                            <h4>Costo de envío: $ @{{ shippingCost }}</h4>
                        </div>

                        <div class="form-group text-center">
                            <button class="btn btn-primary btn-general btn-general--form" @click="store()">Confirmar compra</button>
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
                email: '',
                name: "",
                address:"",
                location:"",
                totalGuest: 0,
                shippingCost: 0
            }
        },
        methods: {

            store() {

                axios.post("{{ url('/guest/store') }}", {
                    email: this.email,
                    name: this.name,
                    address: this.address,
                    location: this.location
                })
                .then(res => {

                    if(res.data.success == true){
                        let cart = window.localStorage.getItem("cart")
                        window.location.href="{{ url('/checkout/') }}"+"?cart="+cart+"&"+"email="+this.email+"&name="+this.name+"&location="+this.location
                    }

                })
                .catch(err => {
                    $.each(err.response.data.errors, function(key, value) {
                        alertify.error(value[0])
                    });
                })

            },
            getPrice(){

                let products = JSON.parse(window.localStorage.getItem('cart'))
                    
                if(products != null){

                    axios.post("{{ url('/guest/carts/prices') }}", {products: products, location: this.location})
                    .then(res => {
                        this.totalGuest = res.data.total
                        this.shippingCost = res.data.shippingCost
                        this.totalGuest = this.shippingCost + this.totalGuest
                    })

                }

            }

        },
        mounted() {
            this.getPrice()
        }

    })
</script>

@endpush