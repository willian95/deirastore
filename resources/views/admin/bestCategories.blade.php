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
                        Categorías Principal
                    </div>
                    <button class="btn btn-success btn-admin" data-toggle="modal" data-target="#createCategory">añadir</button>
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
                        <div class="card" v-for="bestCategory in bestCategories">
                            <div class="card-body">
                                <p class="">
                                @{{ bestCategory.category.esp_name }}
                                </p>
                                <button class="btn btn-danger" @click="erase(bestCategory.id)"><i class="fa fa-trash"></i></button>
                            </div>
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

    <div class="modal fade" id="createCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Categoría Principal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Categoría</label>
                        <select class="form-control" v-model="category">
                            <option :value="category.id" v-for="category in categories">@{{ category.esp_name }}</option>
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
                    bestCategories:[],
                    categories:[],
                    category:"",
                    pages:0,
                    page:1
                }
            },
            methods:{
                
                store(){

                    axios.post("{{ url('admin/best-category/store') }}", {category: this.category})
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
                fetch(){

                    axios.get("{{ url('/admin/best-category/fetch') }}")
                    .then(res => {

                        if(res.data.success == true){
                            this.bestCategories = res.data.bestCategories
                        }else{

                            alert(res.data.msg)

                        }

                    })
                    .catch(err => {
                        console.log(err.response.data)
                    })

                },
                fetchCategories(){

                    axios.get("{{ url('/categories/all') }}")
                    .then(res => {

                        if(res.data.success == true){
                            this.categories = res.data.categories
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

                        axios.post("{{ url('admin/best-category/delete') }}", {id: id})
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
                this.fetchCategories()
            }

        })
    
    </script>

@endpush