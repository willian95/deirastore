@extends('layouts.admin')

@section('content')
    
    @include('partials.admin.navbar')

    <div class="container content__admin">
        <div class="">
            <div class="">
                <div class="grid_content">
                    <div class="grid_content--item">
                        <div class="title mr-5">
                            Textos e imágenes
                        </div>
    
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
                                        <td>Ubicación</td>
                                        <td>Tipo</td>
                                        <td>Descripción</td>
                                        <td>Acciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(text, index) in texts">
                                        <td>@{{ index + 1 }}</td>
                                        <td>@{{ text.site_location }}</td>
                                        <td>
                                            @{{ text.type }}
                                        </td>
                                        <td>
                                            <img v-if="text.type == 'imagen'" :src="'{{ url('/') }}'+'/images/texts/'+text.image" alt="" style="width: 20%">
                                            <span v-if="text.type == 'texto'">@{{ text.text }}</span>
                                        </td>
                                        <td>
                                            <button data-toggle="modal" data-target="#createText" class="btn btn-success"><i class="fa fa-edit" @click="edit(text)"></i></button>
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

    <div class="modal fade" id="createText" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@{{ modalTitle }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group" v-if="type == 'texto'">
                        <label for="description">Nombre</label>
                        <textarea type="text" class="form-control" id="description" v-model="text"></textarea>
                    </div>
                    
                    <div class="form-group" v-if="type == 'imagen'">
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
                    modalTitle:"Editar Texto",
                    text:'',
                    textId:'',
                    picture:"",
                    imagePreview:"",
                    texts:[],
                    type:"",
                    pages:0,
                    page:1,
                }
            },
            methods:{
                
                store(){    

                    this.update()

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
                edit(text){
                    this.type = text.type
                    if(text.type == "imagen"){

                        if(text.image != null)
                            this.imagePreview = "{{ url('/') }}"+"/images/texts/"+text.image
                        else
                            this.imagePreview = ""

                    }else{
                        this.text = text.text
                    }
                    this.textId = text.id
                    
               
                },
                update(){

                    let formData = new FormData()
                    formData.append("id", this.textId)
                    formData.append("text", this.text)
                    formData.append("image", this.picture)

                    axios.post("{{ url('admin/text/update') }}", formData)
                    .then(res => {
                        
                        if(res.data.success == true){
                            alert(res.data.msg)
                            this.text=""
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

                    axios.get("{{ url('admin/text/fetch') }}"+"/"+this.page)
                    .then(res => {
                        
                        this.pages = Math.ceil(res.data.textsCount / 10)
                        this.texts = res.data.texts

                    })
                    .catch(err => {
                        console.log(err.response.data)
                    })

                }
    

            },
            mounted(){
                this.fetch()

            }

        })
    
    </script>

@endpush