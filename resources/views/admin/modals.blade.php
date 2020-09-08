@extends('layouts.admin')

@section('content')
    
    @include('partials.admin.navbar')

    <div class="container content__admin">

        <div class="loader-cover-custom" v-if="loading == true">
            <div class="loader-custom"></div>
        </div>

        <div class="">
            <div class="">
                <div class="grid_content">
                    <div class="grid_content--item">
                        <div class="title mr-5">
                            Pop-Up
                        </div>
    
                    </div>

                </div>
            </div>
        </div>

        <div class="container">

            <div class="row">
                <div class="col-md-4">
                    <label for="">Imagen</label>
                    <input class="form-control" type="file" @change="onImageChange" accept="image/*">
                    <img alt="" :src="imagePreview" style="width: 50%">
                    <div class="form-check" v-if="imagePreview">
                        <input class="form-check-input" type="checkbox" v-model="deleteImage" id="defaultCheck1">
                        <label class="form-check-label" for="defaultCheck1">
                            Eliminar imágen
                        </label>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="">Texto</label>
                    <input class="form-control" type="text" v-model="text">
                </div>
                <div class="col-md-4">
                    <label for="">Status</label>
                    <select class="form-control" v-model="status">
                        <option value="activado">Activado</option>
                        <option value="desactivado">Desactivado</option>
                    </select>
                </div>
            </div>

            <div class="row" style="margin-top: 15px;">
                <div class="col-12">
                    <p class="text-center">
                        <button class="btn btn-success" @click="update()">Actualizar</button>
                    </p>
                </div>
            </div>

        </div>
   
    </div>

    

@endsection

@push('scripts')

    <script>
        
        const app = new Vue({
            el: '#dev-app',
            data(){
                return{
                    text:"",
                    picture:"",
                    status:"desactivado",
                    imagePreview:"",
                    deleteImage:false,
                    loading:false

                }
            },
            methods:{
                
                onImageChange(e){
                    this.picture = e.target.files[0];

                    this.imagePreview = URL.createObjectURL(this.picture);
                    let files = e.target.files || e.dataTransfer.files;
                    if (!files.length)
                        return;
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
                update(){

                    this.loading = true

                    let formData = new FormData()
                    formData.append("text", this.text)
                    formData.append("image", this.picture)
                    formData.append("deleteImage", this.deleteImage)
                    formData.append("status", this.status)

                    axios.post("{{ url('admin/pop-up/update') }}", formData)
                    .then(res => {
                        
                        this.loading = false

                        if(res.data.success == true){
                            
                            swal({
                                icon: "success",
                                title: res.data.msg,
                            })

                            if(this.deleteImage == true){
                                this.imagePreview = null
                                this.deleteImage = false
                            }

                        }else{
                            swal({
                                icon: "error",
                                title: res.data.msg,
                            })
                        }

                    })
                    .catch(err => {
                        this.loading = false
                        $.each(err.response.data.errors, function(key, value){
                            alert(value)
                        });
                    })

                },
                fetch(){

                    axios.get("{{ url('admin/pop-up/fetch') }}")
                    .then(res => {
                        console.log(res)
                       this.text = res.data.modal.text
                       this.imagePreview = res.data.modal.image
                       this.status = res.data.modal.status

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