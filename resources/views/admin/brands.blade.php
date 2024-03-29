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


            <div class="grid_content">
                <div class="grid_content--item">
                 <div class="title mr-5">
                    Tiendas
                 </div>
                 <button class="btn btn-success btn-admin" data-toggle="modal" data-target="#createBrand" @click="changeTitle()">añadir</button>
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
                        <div class="card" v-for="brand in brands">
                            <div class="card-body">
                                <p class="">
                                @{{ brand.name }}
                                </p>
                                <button class="btn btn-success" @click="edit(brand)" data-toggle="modal" data-target="#createBrand"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-danger" @click="erase(brand.id)"><i class="fa fa-trash"></i></button>
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
                            <a class="page-link" v-if="page > 1" @click="fetch(page - 1)"><i class="fa fa-long-arrow-left" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="page-item" v-for="index in pages">
                            <a class="page-link" style="background-color: #d32b2b; color: #fff !important;" href="#" v-if="page == index && index >= page - 3 &&  index < page + 3"  :key="index" @click="fetch(index)" >@{{ index }}</a>
                            <a class="page-link" v-if="page != index && index >= page - 3 &&  index < page + 3"  :key="index" @click="fetch(index)" >@{{ index }}</a> 
                        </li>
                        <li class="line-pag">
                            <a class="page-link" v-if="page < pages" @click="fetch(page + 6)"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                            </a>
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
                    <div class="form-group">
                        <label for="picture">Imagen</label>
                        <input type="file" id="image" class="form-control" id="picture" ref="file" @change="onImageChange" accept="image/*">
                    </div>
                    <div class="form-group">
                        <img id="blah" :src="imagePreview" class="full-image" style="margin-top: 10px; width: 40%">
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
                    modalTitle:"Crear tienda",
                    isEdit:false,
                    name:'',
                    picture:"",
                    imagePreview:"",
                    brandId:'',
                    brands:[],
                    pages:0,
                    page:1,
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

                            axios.post("{{ route('admin.brands.store') }}", formData)
                            .then(res => {
                                
                                if(res.data.success == true){

                                    alert(res.data.msg)
                                    this.name = ""
                                    this.imagePreview = ""
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

                    if($("#image").val() == null){
                        alert("Imagen es requerida")
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
                    this.modalTitle = "Crear tienda"
                    this.isEdit = false
                    this.name = ""
                    this.imagePreview = ""
                    $("#image").val(null)
                },
                edit(brand){
                    
                    this.name = brand.name
                    this.modalTitle = "Editar tienda"
                    this.brandId = brand.id
                    this.isEdit = true
                    this.imagePreview = "{{ url('/') }}"+"/images/brands/"+brand.image

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
                fetch(page = 1){

                    this.page = page

                    axios.post("{{ route('admin.brands.fetch') }}", {page: page})
                    .then(res => {

                        if(res.data.success == true){
                            this.pages = Math.ceil(res.data.brandsCount / 10)
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

                        axios.post("{{ route('admin.banner.delete') }}", {id: id})
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