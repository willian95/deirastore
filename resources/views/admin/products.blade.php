@extends('layouts.admin')

@section('content')

    @include('partials.admin.navbar')
    
    <div class="container content__admin">


        <div class="loader-cover-custom" v-if="loading == true">
            <div class="loader-custom"></div>
        </div>

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
                     Productos
                 </div>

                 <button class="btn btn-success btn-admin" data-toggle="modal" data-target="#createProduct" @click="changeTitle()">añadir</button>

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
     
            <div class="content_title">
                <div class="content_title__item">
                    <p>Nombre</p>
                </div>
                <div class="content_title__item ml-auto mr-12">
                    <p>Acciones</p>
                </div>
            </div>
            <div class="grid__product">
                <div class="card" v-for="product in products">
                    <div class="card-body ">
                        <p class="">
                        @{{ product.name }}
                        </p>
                        <button class="btn btn-success" @click="edit(product)" data-toggle="modal" data-target="#createProduct"><i class="fa fa-edit"></i></button>
                        <button v-if="product.deleted_at == null" class="btn btn-danger" @click="erase(product.id)" title="ocultar"><i class="fa fa-ban"></i></button>
                        <button v-else class="btn btn-info" @click="restore(product.id)" title="restaurar"><i class="fa fa-clone"></i></button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Create Modal -->

    <div class="modal fade modal-admin" id="createProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@{{ modalTitle }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">

                        <div class="form-group col-md-6">
                            <label for="name">Titulo</label>
                            <input type="text" class="form-control" id="name" v-model="name">
                        </div>
                    
                        <div class="form-group col-md-6">
                            <label for="subTitle">Sub-titulo</label>
                            <input type="text" class="form-control" id="subTitle" v-model="subTitle">
                        </div>
                
                        <div class="form-group col-md-6">
                            <label for="picture">Imagen</label>
                            <input type="file" class="form-control" id="picture" ref="file" @change="onImageChange" accept="image/*">
                        </div>
                        <div class="form-group">
                            <img id="blah" :src="imagePreview" class="full-image" style="margin-top: 10px; width: 40%">
                        </div>


                        <div class="form-group col-md-12">
                            <label for="min_description">Descripción minima</label>
                            <input type="text" class="form-control" id="min_description" v-model="min_description">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Descripción</label>
                            <textarea class="form-control" v-model="description"></textarea>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="stock">Stock</label>
                            <input type="text" class="form-control" id="stock" v-model="stock" @keypress="isNumber($event)">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="vpn">VPN</label>
                            <input type="text" class="form-control" id="vpn" v-model="vpn">
                        </div>


                    
                        <div class="form-group col-md-6">
                            <label for="product_type">Tipo de producto</label>
                            <input type="text" class="form-control" id="product_type" v-model="product_type">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="product_material">Tipo de material</label>
                            <input type="text" class="form-control" id="product_material" v-model="product_material">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="dimenssions">Dimensiones</label>
                            <input type="text" class="form-control" id="dimenssions" v-model="dimenssions">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="weight">Peso</label>
                            <input type="text" class="form-control" id="weight" v-model="weight">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="features">Características</label>
                            <input type="text" class="form-control" id="features" v-model="features">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="location">Localización</label>
                            <input type="text" class="form-control" id="location" v-model="location">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="warranty">Garantía</label>
                            <input type="text" class="form-control" id="warranty" v-model="warranty">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="color">Color</label>
                            <input type="text" class="form-control" id="color" v-model="color">
                        </div>

                            <!----categoria ---->
                        <div class="form-group col-md-6">
                            <div class="">
                                <label style="visibility:hidden;">c</label>
                                <button class="btn btn-success" @click="openCategoryForm()">
                                    +
                                </button>

                                <label for="category">categoría</label>
                                <select class="form-control" v-model="categoryId">
                                    <option :value="category.id" v-for="category in categories">@{{ category.name }}</option>
                                </select>
                            </div>

                            
                            <div class="row" v-if="showCategoryForm == true">
                                <div class="col-12">
                                    <h3 class="text-center">Nueva categoría</h3>
                                    <div class="form-group">
                                        <label for="name">nombre</label>
                                        <input type="text" class="form-control" id="categoryName" v-model="categoryName">
                                        <label for="name">Imagen</label>
                                        <input type="file" class="form-control"  id="categoryImage" @change="onImageCategoryChange" accept="image/*">
                                        <div class="form-group">
                                            <img :src="imageCategoryPreview" class="full-image" style="margin-top: 10px; width: 40%">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="button" class="btn btn-secondary" @click="closeCategoryForm()">Close</button>
                                    <button type="button" class="btn btn-primary" @click="storeCategory()">Save changes</button>
                                </div>
                            </div>
                        </div>
                        <!-------Brand---->
                        <div class="form-group col-md-6">
                            <div class="">
                                <div class="">
                                    <label style="visibility:hidden;">c</label>
                                    <button class="btn btn-success" @click="openBrandForm()">
                                        +
                                    </button>
                                
                            
                                    
                                        <label for="brand">Tienda</label>
                                        <select class="form-control" v-model="brandId">
                                            <option :value="brand.id" v-for="brand in brands">@{{ brand.name }}</option>
                                        </select>
                            
                                    </div>
                            </div>

                            <div class="row" v-if="showBrandForm == true">
                                <div class="col-12">
                                    <h3 class="text-center">Nueva tienda</h3>
                                    <div class="form-group">
                                        <label for="name">nombre</label>
                                        <input type="text" class="form-control" id="brandName" v-model="brandName">
                                        <label for="name">Imagen</label>
                                        <input type="file" class="form-control"  id="brandImage" @change="onImageBrandChange" accept="image/*">
                                        <div class="form-group">
                                            <img :src="imageBrandPreview" class="full-image" style="margin-top: 10px; width: 40%">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="button" class="btn btn-secondary" @click="closeBrandForm()">Close</button>
                                    <button type="button" class="btn btn-primary" @click="storeBrand()">Save changes</button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="price">precio (en Dólares)</label>
                            <input type="text" class="form-control" id="price" v-model="price" @keypress="isNumberDot($event)">
                        </div>
                        <!--<div class="form-group">
                            <label for="subPrice">precio alternativo</label>
                            <input type="text" class="form-control" id="price" v-model="subPrice" @keypress="isNumber()">
                        </div>-->

                    </div>




                  <!--   <div class="container-fluid">
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
                                    <label for="name">Imagen</label>
                                    <input type="file" class="form-control"  id="categoryImage" @change="onImageCategoryChange" accept="image/*">
                                    <div class="form-group">
                                        <img :src="imageCategoryPreview" class="full-image" style="margin-top: 10px; width: 40%">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="button" class="btn btn-secondary" @click="closeCategoryForm()">Close</button>
                                <button type="button" class="btn btn-primary" @click="storeCategory()">Save changes</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-1">
                                <label style="visibility:hidden;">c</label>
                                <button class="btn btn-success" @click="openBrandForm()">
                                    +
                                </button>
                            </div>
                            <div class="col-11">
                                <div class="form-group">
                                    <label for="brand">Tienda</label>
                                    <select class="form-control" v-model="brandId">
                                        <option :value="brand.id" v-for="brand in brands">@{{ brand.name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row" v-if="showBrandForm == true">
                            <div class="col-12">
                                <h3 class="text-center">Nueva tienda</h3>
                                <div class="form-group">
                                    <label for="name">nombre</label>
                                    <input type="text" class="form-control" id="brandName" v-model="brandName">
                                    <label for="name">Imagen</label>
                                    <input type="file" class="form-control"  id="brandImage" @change="onImageBrandChange" accept="image/*">
                                    <div class="form-group">
                                        <img :src="imageBrandPreview" class="full-image" style="margin-top: 10px; width: 40%">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="button" class="btn btn-secondary" @click="closeBrandForm()">Close</button>
                                <button type="button" class="btn btn-primary" @click="storeBrand()">Save changes</button>
                            </div>
                        </div>

                    </div>
-->
                  
                    
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

    <div class="modal fade  modal-admin" id="createCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    brandId:"",
                    categories:[],
                    products:[],
                    pages:0,
                    page:1,
                    query:"",
                    categoryName:"",
                    categoryImage:"",
                    imageCategoryPreview:"",
                    showCategoryForm:false,
                    brandName:"",
                    brandImage:"",
                    imageBrandPreview:"",
                    showBrandForm:false,
                    brands:[],
                    loading:false,
                    //sku:"",
                    stock:"",
                    vpn:"",
                    min_description:"",
                    product_type:"",
                    product_material:"",
                    dimenssions:"",
                    weight:"",
                    features:"",
                    location:"",
                    warranty:"",
                    color:""
                }
            },
            methods:{
                onImageCategoryChange(e){
                    this.categoryImage = e.target.files[0];

                    this.imageCategoryPreview = URL.createObjectURL(this.categoryImage);
                    let files = e.target.files || e.dataTransfer.files;
                    if (!files.length)
                        return;
                    //this.view_image = false
                    this.createCategoryImage(files[0]);
                },
                createCategoryImage(file) {
                    let reader = new FileReader();
                    let vm = this;
                    reader.onload = (e) => {
                        vm.categoryImage = e.target.result;
                    };
                    reader.readAsDataURL(file);
                },
                onImageBrandChange(e){
                    this.brandImage = e.target.files[0];

                    this.imageBrandPreview = URL.createObjectURL(this.brandImage);
                    let files = e.target.files || e.dataTransfer.files;
                    if (!files.length)
                        return;
                    //this.view_image = false
                    this.createBrandImage(files[0]);
                },
                createBrandImage(file) {
                    let reader = new FileReader();
                    let vm = this;
                    reader.onload = (e) => {
                        vm.BrandImage = e.target.result;
                    };
                    reader.readAsDataURL(file);
                },
                store(){

                    this.loading = true

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
                            formData.append("brandId", this.brandId)
                            formData.append("sku", this.sku)
                            formData.append("vpn", this.vpn)
                            formData.append("stock",this.stock)
                            formData.append("min_description", this.min_description)
                            formData.append("product_type", this.product_type)
                            formData.append("product_material", this.product_material)
                            formData.append("dimenssions", this.dimenssions)
                            formData.append("weight", this.weight)
                            formData.append("features", this.features)
                            formData.append("location", this.location)
                            formData.append("warranty", this.warranty)
                            formData.append("color", this.color)

                            axios.post("{{ route('admin.products.store') }}", formData, {
                                headers: {
                                'Content-Type': 'multipart/form-data',
                                }
                            })
                            .then(res => {
                                this.loading = false
                                if(res.data.success == true){
                                    alertify.success(res.data.msg)
                                    this.name = ""
                                    this.price = ""
                                    this.subPrice = ""
                                    this.picture = null
                                    this.subTitle = ""
                                    this.description = ""
                                    this.categoryId = ""
                                    this.imagePreview = ""
                                    this.sku=""
                                    this.vpn=""
                                    this.min_description=""
                                    this.product_type=""
                                    this.product_material=""
                                    this.dimenssions=""
                                    this.weight=""
                                    this.features=""
                                    this.location=""
                                    this.warranty=""
                                    this.color =""
                                    this.fetch()
                                }else{
                                    alertify.error(res.data.msg)
                                }

                            })
                            .catch(err => {
                                this.loading = false
                                $.each(err.response.data.errors, function(key, value){
                                    alertify.error(value[0])
                                });
                            })

                        }

                    }

                },
                isNumberDot(evt) {
                    evt = (evt) ? evt : window.event;
                    var charCode = (evt.which) ? evt.which : evt.keyCode;
                    if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                        evt.preventDefault();;
                    } else {
                        return true;
                    }
                },
                isNumber(evt) {
                    evt = (evt) ? evt : window.event;
                    var charCode = (evt.which) ? evt.which : evt.keyCode;
                    if ((charCode > 31 && (charCode < 48 || charCode > 57))) {
                        evt.preventDefault();;
                    } else {
                        return true;
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

                    return error;

                },
                storeCategory(){

                    if(!this.formCategoryHasError()){

                        let formData = new FormData()
                        formData.append("name", this.categoryName)
                        formData.append("image", this.categoryImage)

                        axios.post("{{ route('admin.categories.store') }}", formData)
                        .then(res => {
                            
                            if(res.data.success == true){

                                alert(res.data.msg)
                                this.categoryName = ""
                                this.cateogoryImage = ""
                                this.imageCategoryPreview = ""
                                $("#categoryImage").val(null)
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
                storeBrand(){

                    if(!this.formBrandHasError()){

                        let formData = new FormData()
                        formData.append("name", this.brandName)
                        formData.append("image", this.brandImage)

                        axios.post("{{ route('admin.brands.store') }}", formData)
                        .then(res => {
                            
                            if(res.data.success == true){

                                alert(res.data.msg)
                                this.brandName = ""
                                this.brandImage = ""
                                this.imageBrandPreview = ""
                                $("#brandImage").val(null)
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
                    formBrandHasError(){

                        let error = false

                        if(this.brandName == ""){
                            alert("Campo nombre es requerido")
                            error = true
                        }

                        if(this.brandImage == ""){
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
                    this.brandId = ""
                    this.imagePreview = ""
                    this.sku=""
                    this.vpn=""
                    this.min_description=""
                    this.product_type=""
                    this.product_material=""
                    this.dimenssions=""
                    this.weight=""
                    this.features=""
                    this.location=""
                    this.warranty=""
                    this.color=""
                    $("#picture").val(null)
                },
                edit(product){

                    this.name = product.name
                    this.modalTitle = "Editar Producto"
                    this.productId = product.id
                    this.isEdit = true
                    this.price = product.external_price
                    this.subPrice = product.sub_price
                    this.picture = null
                    this.subTitle = product.sub_title
                    this.description = product.description
                    this.productId = product.id 
                    this.categoryId = product.category_id
                    this.brandId = product.brand_id
                    if(product.picture.indexOf("http") > -1){
                        this.imagePreview = product.picture
                    }else{
                        this.imagePreview = "{{ url('/') }}"+"/images/products/"+product.picture
                    }
                    
                    this.vpn=product.sku
                    //this.vpn=product.vpn
                    this.min_description=product.min_description
                    this.product_type=product.product_type
                    this.product_material=product.product_material
                    this.dimenssions=product.dimenssions
                    this.weight=product.weight
                    this.features=product.features
                    this.location=product.location
                    this.warranty=product.warranty
                    this.color = product.color

                },
                update(){

                    this.loading = true

                    let formData = new FormData()
                    formData.append("name", this.name)
                    formData.append("price", this.price)
                    formData.append("subPrice", this.subPrice)
                    formData.append("picture", this.picture)
                    formData.append("subTitle", this.subTitle)
                    formData.append("description", this.description)
                    formData.append("categoryId", this.categoryId)
                    formData.append("brandId", this.brandId)
                    formData.append("productId", this.productId)
                    formData.append("brandId", this.brandId)
                    formData.append("sku", this.sku)
                    formData.append("vpn", this.vpn)
                    formData.append("min_description", this.min_description)
                    formData.append("product_type", this.product_type)
                    formData.append("product_material", this.product_material)
                    formData.append("dimenssions", this.dimenssions)
                    formData.append("weight", this.weight)
                    formData.append("features", this.features)
                    formData.append("location", this.location)
                    formData.append("warranty", this.warranty)
                    formData.append("color", this.color)

                    axios.post("{{ route('admin.products.update') }}", formData,  {
                        headers: {
                        'Content-Type': 'multipart/form-data',
                        }
                    })
                    .then(res => {
                        
                        this.loading = false

                        if(res.data.success == true){
                            alertify.success(res.data.msg)
                            this.name = ""
                            this.price = ""
                            this.subPrice = ""
                            this.picture = null
                            this.subTitle = ""
                            this.description = ""
                            this.categoryId = ""
                            this.brandId = ""
                            this.imagePreview = ""
                            this.sku=""
                            this.vpn=""
                            this.min_description=""
                            this.product_type=""
                            this.product_material=""
                            this.dimenssions=""
                            this.weight=""
                            this.features=""
                            this.location=""
                            this.warranty=""
                            this.color=""
                            this.fetch()
                        }else{
                            alertify.error(res.data.msg)
                        }
                    })
                    .catch(err => {
                        this.loading = false
                        $.each(err.response.data.errors, function(key, value){
                            alertify.error(value[0])
                        });
                    })

                },
                fetch(page = 1){

                    this.page = page
                   
                    axios.post("{{ route('admin.products.fetch') }}", {page: page})
                    .then(res => {
                       
                        this.products = res.data.products
                        this.pages = Math.ceil(res.data.productsCount / 10)
                        this.categories = res.data.categories
                        this.brands = res.data.brands

                    })
                    .catch(err => {
                        console.log(err.response.data)
                    })

                },
                
                search(){

                    if(this.query.length > 0){
                        this.pages = 0;
                        axios.post("{{ route('admin.products.search') }}", {search: this.query, page: this.page})
                        .then(res => {
                            this.products = res.data.products
                            this.pages = Math.ceil(res.data.productsCount / 20)
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
                        this.loading = true
                        axios.post("{{ route('admin.products.delete') }}", {id: id})
                        .then(res => {
                            this.loading = false
                            alertify.success(res.data.msg)
                            this.fetch()
                        })
                        .catch(err => {
                            this.loading = false
                            console.log(err.response.data)
                        })

                    }

                },
                restore(id){

                    this.loading = true

                    if(confirm('¿Estás seguro?')){

                        axios.post("{{ route('admin.products.restore') }}", {id: id})
                        .then(res => {
                            this.loading = false
                            alertify.success(res.data.msg)
                            this.fetch()
                        })
                        .catch(err => {
                            this.loading = false
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
                openBrandForm(){
                    this.showBrandForm = true
                },
                closeBrandForm(){
                    this.showBrandForm = false
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