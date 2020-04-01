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
                            <button class="btn btn-success" data-toggle="modal" data-target="#createProduct" @click="changeTitle()">añadir</button>
                        </p>
                    </div>
                </div>

                <div class="card" v-for="product in products">
                    <div class="card-body">
                        <p class="text-center">
                        @{{ product.name }}
                        </p>
                        <button class="btn btn-success" @click="edit(product)" data-toggle="modal" data-target="#createProduct">editar</button>
                        <button class="btn btn-danger" @click="erase(product.id)">eliminar</button>
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

    <div class="modal fade" id="createProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <label for="picture">Imagen</label>
                        <input type="file" class="form-control" id="picture" ref="file" @change="onImageChange" accept="image/*">
                    </div>
                    <div class="form-group">
                        <img id="blah" :src="imagePreview" class="full-image" style="margin-top: 10px; width: 40%">
                    </div>
                    <div class="form-group">
                        <label for="name">Titulo</label>
                        <input type="text" class="form-control" id="name" v-model="name">
                    </div>
                    <div class="form-group">
                        <label for="subTitle">Sub-titulo</label>
                        <input type="text" class="form-control" id="subTitle" v-model="subTitle">
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-1">
                                <label style="visibility:hidden;">c</label>
                                <button class="btn btn-success" @click="openCategoryForm()">
                                    +
                                </button>
                            </div>
                            <div class="col-11">
                                <div class="form-group">
                                    <label for="category">categoría</label>
                                    <select class="form-control" v-model="categoryId">
                                        <option :value="category.id" v-for="category in categories">@{{ category.name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row" v-if="showCategoryForm == true">
                            <div class="col-12">
                                <h3 class="text-center">Nueva categoría</h3>
                                <div class="form-group">
                                    <label for="name">nombre</label>
                                    <input type="text" class="form-control" id="categoryName" v-model="categoryName">
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="button" class="btn btn-secondary" @click="closeCategoryForm()">Close</button>
                                <button type="button" class="btn btn-primary" @click="storeCategory()">Save changes</button>
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="price">precio</label>
                        <input type="text" class="form-control" id="price" v-model="price" @keypress="isNumber()">
                    </div>
                    <div class="form-group">
                        <label for="subPrice">precio alternativo</label>
                        <input type="text" class="form-control" id="price" v-model="subPrice" @keypress="isNumber()">
                    </div>
                    <div class="form-group">
                        <label for="description">descripción</label>
                        <textarea class="form-control" v-model="description"></textarea>
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

    <!-- add category modal -->

    <div class="modal fade" id="createCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear categoría</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">nombre</label>
                        <input type="text" class="form-control" id="categoryName" v-model="categoryName">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="storeCategory()">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- add category modal -->

@endsection

@push('scripts')

    <script>
        
        const app = new Vue({
            el: '#dev-app',
            data(){
                return{
                    modalTitle:"Crear producto",
                    isEdit:false,
                    imagePreview:"",
                    name:'',
                    price:'',
                    subPrice:"",
                    picture:null,
                    subTitle:"",
                    description:"",
                    categoryId:"",
                    productId:'',
                    categories:[],
                    products:[],
                    pages:0,
                    query:"",
                    categoryName:"",
                    showCategoryForm:false
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
                            formData.append("price", this.price)
                            formData.append("subPrice", this.subPrice)
                            formData.append("picture", this.picture)
                            formData.append("subTitle", this.subTitle)
                            formData.append("description", this.description)
                            formData.append("categoryId", this.categoryId)

                            axios.post("{{ route('admin.products.store') }}", formData, {
                                headers: {
                                'Content-Type': 'multipart/form-data',
                                }
                            })
                            .then(res => {
                                
                                if(res.data.success == true){
                                    alert(res.data.msg)
                                    this.name = ""
                                    this.price = ""
                                    this.subPrice = ""
                                    this.picture = null
                                    this.subTitle = ""
                                    this.description = ""
                                    this.categoryId = ""
                                    this.imagePreview = ""
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

                    }

                },
                formHasError(){

                    let error = false

                    if(this.name == ""){
                        alert("Campo nombre es requerido")
                        error = true
                    }

                    if(this.isEdit == false){
                        if(this.picture == null){
                            alert("Campo imagen es requerido")
                            error = true
                        }
                    }

                    if(this.description == ""){
                        alert("Campo descripción es requerido")
                        error = true
                    }

                    if(this.price == ""){
                        alert("Campo precio es requerido")
                        error = true
                    }

                    return error;

                },
                storeCategory(){

                    if(!this.formCategoryHasError()){

                        axios.post("{{ route('admin.categories.store') }}", {name: this.categoryName})
                        .then(res => {
                            
                            if(res.data.success == true){

                                alert(res.data.msg)
                                this.categoryName = ""
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

                },
                formCategoryHasError(){

                    let error = false

                    if(this.categoryName == ""){
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
                    this.modalTitle = "Crear producto"
                    this.isEdit = false
                    this.name = ""
                    this.price = ""
                    this.subPrice = ""
                    this.picture = null
                    this.subTitle = ""
                    this.description = ""
                    this.productId = ""
                    this.imagePreview = ""
                    $("#picture").val(null)
                },
                edit(product){

                    this.name = product.name
                    this.modalTitle = "Editar Producto"
                    this.productId = product.id
                    this.isEdit = true
                    this.price = product.price
                    this.subPrice = product.sub_price
                    this.picture = null
                    this.subTitle = product.sub_title
                    this.description = product.description
                    this.productId = product.id 
                    this.categoryId = product.category_id
                    this.imagePreview = "{{ url('/') }}"+"/images/products/"+product.picture

                },
                update(){

                    let formData = new FormData()
                    formData.append("name", this.name)
                    formData.append("price", this.price)
                    formData.append("subPrice", this.subPrice)
                    formData.append("picture", this.picture)
                    formData.append("subTitle", this.subTitle)
                    formData.append("description", this.description)
                    formData.append("categoryId", this.categoryId)
                    formData.append("productId", this.productId)

                    axios.post("{{ route('admin.products.update') }}", formData,  {
                        headers: {
                        'Content-Type': 'multipart/form-data',
                        }
                    })
                    .then(res => {
                        
                        if(res.data.success == true){
                            alert(res.data.msg)
                            this.name = ""
                            this.price = ""
                            this.subPrice = ""
                            this.picture = null
                            this.subTitle = ""
                            this.description = ""
                            this.categoryId = ""
                            this.imagePreview = ""
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

                   
                    axios.post("{{ route('admin.products.fetch') }}", {page: page})
                    .then(res => {
                       
                        this.products = res.data.products
                        this.pages = Math.ceil(res.data.productsCount / 10)
                        this.categories = res.data.categories

                    })
                    .catch(err => {
                        console.log(err.response.data)
                    })

                },
                search(){

                    if(this.query.length > 0){
                        this.pages = 0;
                        axios.post("{{ route('admin.products.search') }}", {search: this.query})
                        .then(res => {
                            this.products = res.data.products
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

                        axios.post("{{ route('admin.products.delete') }}", {id: id})
                        .then(res => {
                            alert(res.data.msg)
                            this.fetch()
                        })
                        .catch(err => {
                            console.log(err.response.data)
                        })

                    }

                },
                openCategoryForm(){
                    this.showCategoryForm = true
                },
                closeCategoryForm(){
                    this.showCategoryForm = false
                },
                isNumber: function(evt) {
                    evt = (evt) ? evt : window.event;
                    var charCode = (evt.which) ? evt.which : evt.keyCode;

                    if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                        evt.preventDefault();;
                    } else {
                        return true;
                    }
                }

            },
            mounted(){
                this.fetch()
            }

        })

    </script>

@endpush