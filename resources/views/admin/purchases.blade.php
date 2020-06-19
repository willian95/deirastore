@extends('layouts.admin')

@section('content')

    @include('partials.admin.navbar')
 
    <div class="container content__admin">
        
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-md-8 offset-md-2 col-12">

                <div class="card">
                    <div class="card-body">
                        <p class="text-center">
                            <button class="btn btn-success" data-toggle="modal" data-target="#addAmount">añadir</button>
                        </p>
                    </div>
                </div>

                <div class="card" v-for="purchase in purchases">
                    <div class="card-body">
                        <p class="text-center">
                            cantidad: @{{ purchase.amount }}
                        </p>
                        <p class="text-center">
                            precio: @{{ purchase.shopping_price }}
                        </p>
                        <p class="text-center">
                            fecha: @{{ purchase.created_at }}
                        </p>
                        <p class="text-center">
                            <button class="btn btn-danger" @click="erase(purchase.id)">eliminar</button>
                        </p>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="line-pag line-pag_r" >
                            <a class="page-link" v-if="page > 1" href="#" @click="fetch(page - 1)"><i class="fa fa-long-arrow-left" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="page-item" v-for="index in pages">
                            <a class="page-link" style="background-color: #d32b2b; color: #fff !important;" href="#" v-if="page == index && index >= page - 3 &&  index < page + 3"  :key="index" @click="fetch(index)" >@{{ index }}</a>
                            <a class="page-link" href="#" v-if="page != index && index >= page - 3 &&  index < page + 3"  :key="index" @click="fetch(index)" >@{{ index }}</a> 
                        </li>
                        <li class="line-pag">
                            <a class="page-link" v-if="page < pages" href="#" @click="fetch(page + 6)"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Create Modal -->

    <div class="modal fade" id="addAmount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <img id="blah" :src="imagePreview" class="full-image" style="margin-top: 10px; width: 40%">
                    </div>
                    <div class="form-group">
                        <label for="name">Titulo</label>
                        <input type="text" class="form-control" id="name" v-model="name" readonly>
                    </div>
                    <div class="form-group">
                        <label for="category">categoría</label>
                        <input type="text" class="form-control" id="name" v-model="category" readonly>
                    </div>
                    <div class="form-group">
                        <label for="price">precio unitario</label>
                        <input type="text" class="form-control" id="price" v-model="price" readonly>
                    </div>
                    <div class="form-group">
                        <label for="amount">Cantidad comprada</label>
                        <input type="text" class="form-control" id="amount" v-model="amount" @keypress="isNumberInteger()">
                    </div>
                    <div class="form-group">
                        <label for="shoppingPrice">Precio de la compra</label>
                        <input type="text" class="form-control" id="shoppingPrice" v-model="shoppingPrice" @keypress="isNumber()">
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

@endsection

@push('scripts')
    
    <script>
        
        const app = new Vue({
            el: '#dev-app',
            data(){
                return{
                    productId:"{!! $id !!}",
                    modalTitle:"Añadir compra",
                    name:"",
                    category:"",
                    price:"",
                    imagePreview:"",
                    amount:0,
                    shoppingPrice:0,
                    pages:0,
                    purchases:[]
                }
            },
            methods:{
                
                getProduct(){
                    
                    axios.get("{{ url('/admin/products/show') }}"+"/"+this.productId)
                    .then(res => {
                       
                       this.name = res.data.product.name
                       this.category = res.data.product.category.name
                       this.price = res.data.product.price
                       this.imagePreview = "{{ url('/') }}"+"/images/products/"+res.data.product.picture

                    })
                    .catch(err => {

                        $.each(err.response.data.errors, function(key, value){
                            alert(value)
                        });

                    })

                },
                isNumber: function(evt) {
                    evt = (evt) ? evt : window.event;
                    var charCode = (evt.which) ? evt.which : evt.keyCode;

                    if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                        evt.preventDefault();;
                    } else {
                        return true;
                    }
                },
                isNumberInteger: function(evt) {
                    evt = (evt) ? evt : window.event;
                    var charCode = (evt.which) ? evt.which : evt.keyCode;

                    if ((charCode > 31 && (charCode < 48 || charCode > 57))) {
                        evt.preventDefault();;
                    } else {
                        return true;
                    }
                },
                store(){

                    let formData = new FormData()
                    formData.append("shoppingPrice", this.shoppingPrice)
                    formData.append("amount", this.amount)
                    formData.append("productId", this.productId)

                    axios.post("{{ route('admin.purchase.store') }}", formData)
                    .then(res => {
                        
                        if(res.data.success == true){

                            alert(res.data.msg)
                            this.shoppingPrice = 0
                            this.amount = 0
                            this.fetch()

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
                erase(id){

                    if(confirm("¿Estás seguro?")){

                        axios.post("{{ route('admin.purchase.delete') }}", {purchaseId: id})
                        .then(res => {

                            if(res.data.success == true){

                                alert(res.data.msg)
                                this.fetch()

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
                fetch(page = 1){

                    axios.post("{{ route('admin.purchase.fetch') }}", {page: page, productId: this.productId})
                    .then(res => {
                        
                        this.pages = Math.ceil(res.data.purchasesCount / 10)
                        this.purchases = res.data.purchases

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value){
                            alert(value)
                        });
                    })

                }


            },
            mounted(){
                this.getProduct()
                this.fetch()
            }

        })
    
    </script>

@endpush