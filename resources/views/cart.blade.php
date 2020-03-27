@extends('layouts.main')

@section('content')

    @include('partials.navbar')

    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-md-8 offset-md-2 col-12">
                
                <div class="card" v-for="item in items">
                    <div class="card-body">

                        @{{ item.product.name }} - @{{ item.amount }}

                        <button class="btn btn-success" data-toggle="modal" data-target="#editCart" @click="edit(item.id, item.amount, item.product.amount)">editar</button>
                        <button class="btn btn-danger" @click="erase(item.id)">eliminar</button>

                    </div>
                </div>

            </div>
        </div>
        <div class="row" v-if="items.length > 0">
            <div class="col-lg-8 offset-lg-2 col-md-8 offset-md-2 col-12">
                
                <!--button class="btn btn-success" @click="payProducts()">checkout</button>-->
                <a href="{{ route('checkout') }}" class="btn btn-success">checkout</a>

            </div>
        </div>
    </div>

    <!-- Create Modal -->

    <div class="modal fade" id="editCart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <input type="number" class="form-control" id="amount" v-model="amount" :max="maxAmount" min="1" @keyup="isNumber()">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="update()">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->

@endsection

@push('scripts')
    
    <script>
        
        const app = new Vue({
            el: '#dev-app',
            data(){
                return{
                    modalTitle:"Editar articulo del carrito",
                    items:[],
                    amount:0,
                    maxAmount:0,
                    itemId:0
                }
            },
            methods:{
                
                getItems(){

                    axios.get("{{ route('cart.items') }}")
                    .then(res => {
                        
                        this.items = res.data.products

                    })
                    .catch(err => {
                        console.log(err.response)
                    })
                
                },
                edit(id, currentAmount, maxAmount){

                    this.itemId = id
                    this.amount = currentAmount
                    this.maxAmount = maxAmount

                },
                update(){

                    if(this.amount != 0){

                        axios.post("{{ route('cart.update') }}", {id: this.itemId, amount: this.amount})
                        .then(res => {

                            if(res.data.success == true){

                                alert(res.data.msg)
                                this.getItems()

                            }
                            else{

                                alert(res.data.msg)

                            }

                        })
                        .catch(err => {

                            $.each(err.response.data.errors, function(key, value){
                                alert(value)
                            });

                        })

                    }else{
                        alert("Campo cantidad no puede estar vacío")
                    }

                },
                erase(id){

                    if(confirm("¿Está seguro de eliminar este producto?")){
                        axios.post("{{ route('cart.delete') }}", {id: id})
                        .then(res => {
                            
                            if(res.data.success == true){

                                alert(res.data.msg)
                                this.getItems()

                            }else{

                                alert(res.data.msg)

                            }

                        })
                        .catch(err => {
                            $.each(err.response.data.errors, function(key, value){
                                alert(value)
                            });
                        })
                    }

                },
                isNumber: function(evt) {

                    evt = (evt) ? evt : window.event;
                    var charCode = (evt.which) ? evt.which : evt.keyCode;

                    if ((charCode > 31 && (charCode < 48 || charCode > 57))) {
                        evt.preventDefault();

                    } else {

                        if(this.amount > this.maxAmount){
                            this.amount = this.maxAmount
                            evt.preventDefault()
                        }else{
                            return true;
                        }   
                        
                    }

                },
                payProducts(){

                    axios.post("{{ route('checkout') }}")
                    .then(res => {

                        if(res.data.success == true){
                            
                            this.getItems()
                            alert(res.data.msg)

                        }else{
                            alert(res.data.msg)
                        }

                    })
                    .cacth(err => {
                        $.each(err.response.data.errors, function(key, value){
                            alert(value)
                        });
                    })

                }


            },
            mounted(){
                this.getItems()
            }

        })
    
    </script>

@endpush