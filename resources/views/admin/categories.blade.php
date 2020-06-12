@extends('layouts.admin')

@section('content')
    
    @include('partials.admin.navbar')

    <div class="container content__admin">
        <div class="bsucador_admin col-md-8">
            <div class="card-body">
                <div class="form-group buscardor-admin">
                   <label for="" class="fa fa-search"></label>
                    <input  type="text" placeholder="Buscar producto..." class="form-control fa fa-search" id="name" v-model="query" @keyup="search()">
                </div>
            </div>
        </div>
        <div class="">
            <div class="">
                <div class="grid_content">
                    <div class="grid_content--item">
                     <div class="title mr-5">
                         Productos
                     </div>
    
                     <button class="btn btn-success btn-admin" data-toggle="modal" data-target="#createCategory" @click="changeTitle()">añadir</button>
    
                    </div>
                
                    <div class="grid_content--item ml-auto mr-4">
                        <div class="title">
                            <span class="page">Pagina:</span>
                            
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
         
              <!--  <div class="card">
                    <div class="card-body">
                        <p class="text-center">
                            <button class="btn btn-success" data-toggle="modal" data-target="#createCategory" @click="changeTitle()">añadir</button>
                        </p>
                    </div>
                </div>-->
                <div class="grid__product">
                    <div class="card">
                        <div class="card-bod">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Categoría</td>
                                        <td>Categoría superior</td>
                                        <td>Acciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(category, index) in categories">
                                        <td>@{{ index + 1 }}</td>
                                        <td>@{{ category.name }}</td>
                                        <td>
                                            <div v-if="category.parent != null">
                                                @{{ category.parent.name }}
                                            </div>
                                        </td>
                                        <td>
                                            <button class="btn btn-success" @click="edit(category)" data-toggle="modal" data-target="#createCategory"><i class="fa fa-edit"></i></button>
                                            <!-----------PORQUE SE REPITE DOS VECES EL ICONO DE TRASH? Faltaba cerrar la etiqueta i------------------>
                                            <button class="btn btn-danger" @click="erase(category.id)"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> 
                </div>
               

                <!--<div class="card" v-for="category in categories">
                    <div class="card-body">
                        <p class="text-center">
                        @{{ category.name }}
                        </p>
                        <button class="btn btn-success" @click="edit(category)" data-toggle="modal" data-target="#createCategory">editar</button>
                        <button class="btn btn-danger" @click="erase(category.id)">eliminar</button>
                    </div>
                </div>-->

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
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" id="name" v-model="name">
                    </div>
                    <div class="form-group">
                        <label for="name">Categoría Padre</label>
                        <select class="form-control" v-model="parentId">
                            <option :value="category.id" v-for="category in allCategories" v-if="category.parent_id == null && category.id != categoryId">
                                @{{ category.name }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="picture">Imagen</label>
                        <input type="file" id="image" class="form-control" id="picture" ref="file" @change="onImageChange" accept="image/*">
                    </div>
                    <div class="form-group">
                        <img id="blah" :src="imagePreview" class="full-image" style="margin-top: 10px; width: 40%" v-if="imagePreview != null">
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
                    picture:"",
                    imagePreview:"",
                    pages:0,
                    page:1,
                    allCategories:[],
                    parentId:"",
                    query:""
                }
            },
            methods:{
                
                store(){

                    if(!this.formHasError()){

                        if(this.isEdit == true){
                            this.update()
                        }else{

                            let formData = new FormData()
                            formData.append("name", this.name)
                            formData.append("image", this.picture)
                            formData.append("parentId", this.parentId)
                            
                            axios.post("{{ route('admin.categories.store') }}", formData)
                            .then(res => {
                                
                                if(res.data.success == true){

                                    alert(res.data.msg)
                                    this.name = ""
                                    this.imagePreview = ""
                                    this.parentId = ""
                                    $("#image").val(null)
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
                onImageChange(e){
                    this.picture = e.target.files[0];

                    this.imagePreview = URL.createObjectURL(this.picture);
                    let files = e.target.files || e.dataTransfer.files;
                    if (!files.length)
                        return;
                    this.view_image = false
                    this.createImage(files[0]);
                },
                createImage(file) {
                    let reader = new FileReader();
                    let vm = this;
                    reader.onload = (e) => {
                        vm.picture = e.target.result;
                    };
                    reader.readAsDataURL(file);
                },
                changeTitle(){
                    this.modalTitle = "Crear categoría"
                    this.isEdit = false
                    this.name = ""
                    this.parentId =""
                },
                edit(category){
                    console.log("test-category", category)
                    this.name = category.name
                    this.modalTitle = "Editar Categoría"
                    this.categoryId = category.id
                    this.isEdit = true
                    if(category.image != null)
                        this.imagePreview = "{{ url('/') }}"+"/images/categories/"+category.image
                    else
                        this.imagePreview = ""
                    
                    this.parentId = category.parent_id
                    console.log("test-parentId-edit", this.parentId)

                },
                update(){

                    let formData = new FormData()
                    formData.append("id", this.categoryId)
                    formData.append("name", this.name)
                    formData.append("image", this.picture)
                    if(this.parentId != undefined)
                        formData.append("parentId", this.parentId)

                    

                    axios.post("{{ route('admin.categories.update') }}", formData)
                    .then(res => {
                        
                        if(res.data.success == true){
                            alert(res.data.msg)
                            this.name=""
                            this.imagePreview = ""
                            this.parentId = ""
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
                fetch(page = 1){

                    this.page = page

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
                fetchAllCategories(){

                    axios.get("{{ url('/categories/all') }}").then(res => {
                        this.allCategories = res.data.categories
                    })

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
                this.fetchAllCategories()
            }

        })
    
    </script>

@endpush