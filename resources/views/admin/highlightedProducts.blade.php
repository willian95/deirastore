@extends('layouts.admin')

@section('content')

    @include('partials.admin.navbar')

    <div class="container content__admin">

        <!--<div class="bsucador_admin col-md-8">
            <div class="card-body">
                <div class="form-group buscardor-admin">
                   <label for="" class="fa fa-search"></label>
                    <input  type="text" placeholder="Buscar marca..." class="form-control fa fa-search" id="name" v-model="query" @keyup="search()">
                </div>
            </div>
        </div>-->

        <div class="">


            <div class="grid_content">
                <div class="grid_content--item">
                    <div class="title mr-5">
                        Productos destacados
                    </div>
                    <button class="btn btn-success btn-admin" data-toggle="modal" data-target="#createHighlightedProduct">añadir</button>
                </div>
            
                <div class="grid_content--item ml-auto mr-4">
            
                </div>
            </div>

            <div class="">

            

                <!--<div class="card">
                    <div class="card-body">
                        <p class="text-center">
                            <button class="btn btn-success" data-toggle="modal" data-target="#createBrand" @click="changeTitle()">añadir</button>
                        </p>
                    </div>
                </div>-->
                <div class="content_title">
                    <div class="content_title__item">
                        <p>Nombre</p>
                    </div>
                    <div class="content_title__item ml-auto mr-12">
                        <p>Acciones</p>
                    </div>
                </div>
                    <div class="grid__product">
                        <div class="card" v-for="highlightedProduct in highlightedProducts">
                            <div class="card-body">
                                <p class="">
                                @{{ highlightedProduct.product.name }}
                                </p>
                                <button class="btn btn-danger" @click="erase(highlightedProduct.id)"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
       

            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li>
                            <a class="page-link" v-if="page > 1" href="#" @click="fetch(page - 1)">Anterior</a>
                        </li>
                        <li class="page-item" v-for="index in pages">
                            <a class="page-link" href="#" v-if="index >= page &&  index < page + 6"  :key="index" @click="fetch(index)" >@{{ index }}</a>
                        </li>
                        <li>
                            <a class="page-link" v-if="page < pages" href="#" @click="fetch(page + 6)">Siguiente</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Create Modal -->

    <div class="modal fade" id="createHighlightedProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Producto destacado</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Producto</label>
                        <input type="text" class="form-control" v-model="searchText" @keyup="search()">
                    </div>

                    <div style="height: 250px; overflow-y: scroll">
                        <ul class="list-group">
                            <li class="list-group-item" v-for="product in products" @click="select(product)">@{{ product.name }}</li>
                        </ul>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="store()">Guardar</button>
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
                    highlightedProducts:[],
                    products:[],
                    product:"",
                    searchText:"",
                    pages:0,
                    page:1
                }
            },
            methods:{
                
                store(){

                    axios.post("{{ url('admin/highlighted-product/store') }}", {product: this.product.id})
                    .then(res => {
                        
                        if(res.data.success == true){

                            alert(res.data.msg)
                            this.product = ""
                            this.fetch()

                        } else{

                            alert(res.data.msg)

                        }

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value){
                            alert(value)
                        });
                    })

                },
                select(product){
                    this.product = product
                    alert("product seleccionado, presione guardar para elegir este producto como destacado")
                },
                search(){
                    
                    axios.post("{{ url('admin/highlighted-product/search') }}", {search: this.searchText})
                    .then(res => {

                        if(res.data.success == true){

                            this.products = res.data.products

                        }else{
                            alert(res.data.msg)
                        }

                    })

                },
                fetch(){

                    axios.get("{{ url('/admin/highlighted-product/fetch') }}")
                    .then(res => {

                        if(res.data.success == true){
                            this.highlightedProducts = res.data.highlightedProduct
                        }else{

                            alert(res.data.msg)

                        }

                    })
                    .catch(err => {
                        console.log(err.response.data)
                    })

                },
                erase(id){

                    if(confirm('¿Estás seguro?')){

                        axios.post("{{ url('admin/highlighted-product/delete') }}", {id: id})
                        .then(res => {
                            if(res.data.success == true){
                                alert(res.data.msg)
                                this.fetch()
                            }else{
                                alert(res.data.msg)
                            }
                        })
                        .catch(err => {
                            console.log(err.response.data)
                        })

                    }

                }

            },
            mounted(){
                this.fetch()
            }

        })
    
    </script>

@endpush