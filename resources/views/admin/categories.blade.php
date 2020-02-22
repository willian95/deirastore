@extends('layouts.main')

@section('content')
    
    @include('partials.navbar')

    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-md-8 offset-md-2 col-12">

                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Buscar</label>
                            <input type="text" class="form-control" id="name" v-model="query" @keyup="search()">
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <p class="text-center">
                            <button class="btn btn-success" data-toggle="modal" data-target="#createCategory" @click="changeTitle()">añadir</button>
                        </p>
                    </div>
                </div>

                <div class="card" v-for="category in categories">
                    <div class="card-body">
                        <p class="text-center">
                        @{{ category.name }}
                        </p>
                        <button class="btn btn-success" @click="edit(category)" data-toggle="modal" data-target="#createCategory">editar</button>
                        <button class="btn btn-danger" @click="erase(category.id)">eliminar</button>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="#" v-for="index in pages" :key="index" @click="fetch(index)" >@{{ index }}</a>
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
                    <h5 class="modal-title" id="exampleModalLabel">@{{ modalTitle }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">nombre</label>
                        <input type="text" class="form-control" id="name" v-model="name">
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
                    modalTitle:"Crear categoría",
                    isEdit:false,
                    name:'',
                    categoryId:'',
                    categories:[],
                    pages:0,
                    query:""
                }
            },
            methods:{
                
                store(){

                    if(!this.formHasError()){

                        if(this.isEdit == true){
                            this.update()
                        }else{

                            axios.post("{{ route('admin.categories.store') }}", {name: this.name})
                            .then(res => {
                                
                                if(res.data.success == true){

                                    alert(res.data.msg)
                                    this.name = ""
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

                        }

                    }

                },
                formHasError(){

                    let error = false

                    if(this.name == ""){
                        alert("Campo nombre es requerido")
                        error = true
                    }

                    return error;

                },
                changeTitle(){
                    this.modalTitle = "Crear categoría"
                    this.isEdit = false
                    this.name = ""
                },
                edit(category){
                    
                    this.name = category.name
                    this.modalTitle = "Editar Categoría"
                    this.categoryId = category.id
                    this.isEdit = true

                },
                update(){

                    axios.post("{{ route('admin.categories.update') }}", {id: this.categoryId, name: this.name})
                    .then(res => {
                        
                        if(res.data.success == true){
                            alert(res.data.msg)
                            this.name = ""
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
                fetch(page = 1){

                    axios.post("{{ route('admin.categories.fetch') }}", {page: page})
                    .then(res => {
                        
                        this.pages = Math.ceil(res.data.categoriesCount / 10)
                        this.categories = res.data.categories

                    })
                    .catch(err => {
                        console.log(err.response.data)
                    })

                },
                search(){

                    if(this.query.length > 0){
                        this.pages = 0;
                        axios.post("{{ route('admin.categories.search') }}", {search: this.query})
                        .then(res => {
                            this.categories = res.data.categories
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

                        axios.post("{{ route('admin.categories.delete') }}", {id: id})
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