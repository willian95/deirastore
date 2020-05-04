@extends('layouts.main')

@section('content')

    @include('partials.navbar')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-md-8 offset-md-2 col-12">

                <img src="{{ url('/').'/images/products/'.$product->picture }}" alt="" style="width: 100%;">

                <h1>{{ $product->name }}</h1>

                @if(Auth::check() && Auth::user()->id)
                    <label for="amount">Cantidad</label>
                    <input type="number" class="form-control" id="amount" v-model="amount" max="{{ $product->amount }}" min="1" readonly>
                    <button class="btn btn-cart" @click="add()"> sumar</button>
                    <button class="btn btn-cart" @click="substract()"> restar</button>

                    <button class="btn btn-info" @click="store()">añadir al carrito</button>
                @else
                    <h3>Debe loguearse para comenzar</h3>
                @endif
            </div>
        </div>
    </div>

    <!-- Create Modal -->

    <div class="modal fade" id="addToCart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@{{ modalTitle }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="amount">Cantidad</label>
                        <input type="number" class="form-control" id="amount" v-model="amount" max="{{ $product->amount }}" min="1" @keyup="isNumber()">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="store()">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->

    @include('partials.footer')

@endsection

@push('scripts')
    
    <script>
            
        const app = new Vue({
            el: '#dev-app',
            data(){
                return{
                    productId:"{!! $product->id !!}",
                    modalTitle: "Añadir al carrito",
                    amount:1,
                    maxAmount:"{!! $product->amount !!}"
                }
            },
            methods:{

                store(){

                    let formData = new FormData()
                    formData.append("productId", this.productId)
                    formData.append("amount", this.amount)

                    axios.post("{{ route('cart.store') }}", formData)
                    .then(res => {

                        if(res.data.success == true){

                            alert(res.data.msg)
                            this.amount = 1;

                        }else{

                            alert(res.data.msg)

                        }

                    })
                    .catch(err => {
                        
                        $.each(err.response.data.errors, function(key, value){
                            alert(value)
                        });

                    })

                },
                add(){

                    if(this.amount + 1 <= this.maxAmount){
                        this.amount++;
                    }

                },
                substract(){

                    if(this.amount - 1 > 0){
                        this.amount--
                    }

                }

            },
            mounted(){
                //this.test()
            }

        })

    </script>

@endpush