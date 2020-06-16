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
                        Mejores Tiendas
                    </div>
                    <button class="btn btn-success btn-admin" data-toggle="modal" data-target="#createBrand">añadir</button>
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
                        <div class="card" v-for="bestStore in bestStores">
                            <div class="card-body">
                                <p class="">
                                @{{ bestStore.brand.name }}
                                </p>
                                <button class="btn btn-danger" @click="erase(bestStore.brand_id)"><i class="fa fa-trash"></i></button>
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

    <div class="modal fade" id="createBrand" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Mejores Tiendas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Marca</label>
                        <select class="form-control" v-model="brand">
                            <option :value="brand.id" v-for="brand in brands">@{{ brand.name }}</option>
                        </select>
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
                    bestStores:[],
                    brands:[],
                    brand:"",
                    pages:0,
                    page:1,
                    query:""
                }
            },
            methods:{
                
                store(){

                    axios.post("{{ url('admin/best-store/store') }}", {brand: this.brand})
                    .then(res => {
                        
                        if(res.data.success == true){

                            alert(res.data.msg)
                            this.brand = ""
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
                update(){

                    let formData = new FormData()
                    formData.append("name", this.name)
                    formData.append("image", this.picture)
                    formData.append("brandId", this.brandId)

                    axios.post("{{ route('admin.brands.update') }}", formData)
                    .then(res => {
                        
                        if(res.data.success == true){
                            alert(res.data.msg)
                            this.name = ""
                            this.imagePreview = ""
                            $("#image").val(null)
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
                fetch(){

                    axios.get("{{ url('/admin/best-store/fetch') }}")
                    .then(res => {

                        if(res.data.success == true){
                            this.bestStores = res.data.bestStores
                        }else{

                            alert(res.data.msg)

                        }

                    })
                    .catch(err => {
                        console.log(err.response.data)
                    })

                },
                fetchBrands(){

                    axios.get("{{ url('/brands/fetch/all') }}")
                    .then(res => {

                        if(res.data.success == true){
                            this.brands = res.data.brands
                        }else{

                            alert(res.data.msg)

                        }

                    })
                    .catch(err => {
                        console.log(err.response.data)
                    })

                },
                search(){

                    if(this.query.length > 0){
                        this.pages = 0;
                        axios.post("{{ route('admin.brands.search') }}", {search: this.query})
                        .then(res => {
                            this.brands = res.data.brands
                        })
                        .catch(err => {
                            console.log(err.response.data)
                        })

                    }else{
                        this.fetch()
                    }

                },
                erase(id){

                    if(confirm('¿Estás seguro?')){

                        axios.post("{{ url('admin/best-store/delete') }}", {id: id})
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
                this.fetchBrands()
            }

        })
    
    </script>

@endpush