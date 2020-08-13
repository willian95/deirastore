@extends('layouts.admin')

@section('content')

    @include('partials.admin.navbar')
 
    <div class="container content__admin">
        <div class="grid_content">
            <div class="grid_content--item">
             <div class="title mr-5">
                Banners
             </div>

             <button class="btn btn-success btn-admin" data-toggle="modal" data-target="#createBanner" @click="changeTitle()">añadir</button>

            </div>
        
      
            </div>
        <div class="">
            <div class="">
            
                <div class="grid__product">
                    <div class="card" >
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Imagen</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(banner, index) in banners">
                                    <td>@{{ index + 1 }}</td>
                                    <td><img :src="'{{ url('/') }}'+'/images/banners/'+banner.image" alt="" style="width: 300px"></td>
                                    <td>
                                        <button class="btn btn-success" @click="edit(banner)" data-toggle="modal" data-target="#createBanner"><i class="fa fa-edit"></i></button>
                                        <button class="btn btn-danger" @click="erase(banner.id)"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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

    <div class="modal fade" id="createBanner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <label for="">Link</label>
                        <input type="text" class="form-control" v-model="link">
                    </div>
                    <div class="form-group">
                        <label for="">Tamaño del banner</label>
                        <select class="form-control" v-model="size">
                            <option value="small">Pequeño</option>
                            <option value="medium">Mediano</option>
                            <option value="large">Grande</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Posición de los elementos</label>
                        <select class="form-control" v-model="position">
                            <option value="izquierda">Izquierda</option>
                            <option value="derecha">Derecha</option>
                        </select>   
                    </div>
                    <div class="form-group">
                        <label for="">Titulo</label>
                        <input type="text" class="form-control" v-model="title">
                    </div>
                    <div class="form-group">
                        <label for="">Color del titulo <div class="color-box" id="title-color"></div></label>
                        <select class="form-control" v-model="titleColor" @change="changeTitleColor()">
                            <option value="#ffffff">Blanco</option>
                            <option value="#2d3436">Negro</option>
                            <option value="#55efc4">Verde Claro</option>
                            <option value="#00b894">Verde Oscuro</option>
                            <option value="#fab1a0">Rojo Claro</option>
                            <option value="#d63031">Rojo Oscuro</option>
                            <option value="#ffeaa7">Amarillo Claro</option>
                            <option value="#fdcb6e">Amarillo Oscuro</option>
                            <option value="#74b9ff">Azul Claro</option>
                            <option value="#0984e3">Azul Oscuro</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Texto</label>
                        <textarea type="text" class="form-control" v-model="text"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Color del texto <div class="color-box" id="text-color"></div></label>
                        <select class="form-control" v-model="textColor" @change="changeTextColor()">
                            <option value="#ffffff">Blanco</option>
                            <option value="#2d3436">Negro</option>
                            <option value="#55efc4">Verde Claro</option>
                            <option value="#00b894">Verde Oscuro</option>
                            <option value="#fab1a0">Rojo Claro</option>
                            <option value="#d63031">Rojo Oscuro</option>
                            <option value="#ffeaa7">Amarillo Claro</option>
                            <option value="#fdcb6e">Amarillo Oscuro</option>
                            <option value="#74b9ff">Azul Claro</option>
                            <option value="#0984e3">Azul Oscuro</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="picture">Imagen</label>
                        <input type="file" id="image" class="form-control" id="picture" ref="file" @change="onImageChange" accept="image/*">
                    </div>
                    <div class="form-group">
                        <img id="blah" :src="imagePreview" class="full-image" style="margin-top: 10px; width: 40%">
                    </div>
                    <div class="form-group">
                        <label for="">Lugar donde aparecerá</label>
                        <select class="form-control" v-model="location">
                            <option value="landing">Landing</option>
                            <option :value="brand.slug" v-for="brand in brands">@{{ brand.name }}</option>
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
                    modalTitle:"Crear banner",
                    isEdit:false,
                    link:'',
                    size:"",
                    picture:"",
                    imagePreview:"",
                    bannerId:'',
                    banners:[],
                    pages:0,
                    page:1,
                    query:"",
                    text:"",
                    position:"izquierda",
                    title:"",
                    buttonText:"",
                    buttonColor:"",
                    buttonTextColor:"",
                    textColor:"",
                    titleColor:"",
                    brands:[],
                    location:""

                }
            },
            methods:{
                
                store(){

                    if(this.isEdit == true){
                        this.update()
                    }else{

                        axios.post("{{ route('admin.banner.store') }}", {location: this.location, titleColor: this.titleColor, textColor: this.textColor, buttonTextColor: this.buttonTextColor, buttonColor: this.buttonColor, buttonText: this.buttonText, text: this.text, title: this.title, position: this.position, link: this.link, size: this.size, image: this.picture})
                        .then(res => {
                            
                            if(res.data.success == true){

                                alert(res.data.msg)
                                this.link = ""
                                this.size = ""
                                this.title = ""
                                this.text = ""
                                this.buttonText =""
                                this.buttonColor =""
                                this.buttonTextColor = ""
                                this.textColor = ""
                                this.titleColor = ""
                                this.location = "landing"
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
                    this.link = ""
                    this.size = ""
                    this.title = ""
                    this.text = ""
                    this.buttonText =""
                    this.buttonColor =""
                    this.buttonTextColor = ""
                    this.textColor = ""
                    this.titleColor = ""
                    this.location = "landing"
                    this.imagePreview = ""
                    $("#image").val(null)
                },
                edit(banner){
                    
                    this.link = banner.link
                    this.modalTitle = "Editar banner"
                    this.size = banner.size
                    this.isEdit = true
                    this.bannerId = banner.id
                    this.title = banner.title
                    this.text = banner.text
                    this.buttonText = banner.button_text
                    this.buttonColor = banner.button_color
                    this.buttonTextColor = banner.button_text_color
                    this.textColor = banner.text_color
                    this.titleColor = banner.title_color
                    this.buttonTextColor = banner.button_text_color
                    this.location = banner.location
                    this.position = banner.position 
                    this.imagePreview = "{{ url('/') }}"+"/images/banners/"+banner.image

                },
                update(){

                    let formData = new FormData()
                    formData.append("id", this.bannerId)
                    formData.append("image", this.picture)
                    formData.append("size", this.size)
                    formData.append("link", this.link)
                    formData.append("position", this.position)
                    formData.append("title", this.title)
                    formData.append("text", this.text)
                    formData.append("buttonText", this.buttonText)
                    formData.append("buttonColor", this.buttonColor)
                    formData.append("buttonTextColor", this.buttonTextColor)
                    formData.append("textColor", this.textColor)
                    formData.append("titleColor", this.titleColor)
                    formData.append("location", this.location)

                    axios.post("{{ route('admin.banner.update') }}", formData)
                    .then(res => {
                        
                        if(res.data.success == true){
                            alert(res.data.msg)
                            this.link = ""
                            this.size = ""
                            this.title = ""
                            this.text = ""
                            this.buttonText =""
                            this.buttonColor =""
                            this.buttonTextColor = ""
                            this.textColor = ""
                            this.titleColor = ""
                            this.location = "landing"
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

                    axios.get("{{ url('/admin/banner/fetch/') }}"+"/"+page)
                    .then(res => {

                        if(res.data.success == true){
                            this.pages = Math.ceil(res.data.bannersCount / 10)
                            this.banners = res.data.banners
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

                },
                changeTitleColor(){

                    $("#title-color").css("background-color", this.titleColor)

                },
                changeTextColor(){

                    $("#text-color").css("background-color", this.textColor)

                },
                changeButtonColor(){

                    $("#button-color").css("background-color", this.buttonColor)

                },
                changeButtonTextColor(){

                    $("#button-text-color").css("background-color", this.buttonTextColor)

                }

            },
            mounted(){
                this.fetch()
                this.fetchBrands()
            }

        })
    
    </script>

@endpush