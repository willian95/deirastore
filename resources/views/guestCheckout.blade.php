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
                            <!-- <label for="email">Email</label> -->
                            <input placeholder="Correo electrónico" type="email" autocomplete="off" class="form-control" id="email" aria-describedby="emailHelp" v-model="email">
                        </div>

                        <div class="form-group">
                            <!-- <label for="email">Email</label> -->
                            <input placeholder="Nombre" type="name" autocomplete="off" class="form-control" id="name" aria-describedby="emailHelp" v-model="name">
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
                name: ""
            }
        },
        methods: {

            store() {

                axios.post("{{ url('/guest/store') }}", {
                    email: this.email,
                    name: this.name
                })
                .then(res => {

                    if(res.data.success == true){
                        let cart = window.localStorage.getItem("cart")
                        window.location.href="{{ url('/checkout/') }}"+"?cart="+cart+"&"+"email="+this.email+"&name="+this.name
                    }

                })
                .catch(err => {
                    $.each(err.response.data.errors, function(key, value) {
                        alertify.error(value)
                    });
                })

            }

        },
        mounted() {
            //this.test()
        }

    })
</script>

@endpush