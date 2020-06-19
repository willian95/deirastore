@extends('layouts.admin')

@section('content')

    @include('partials.admin.navbar')

    <div class="container content__admin">

        <div class="">


            <div class="grid_content">
                <div class="grid_content--item">
                    <div class="title mr-5">
                        Centro de ayuda
                    </div>
                    <button class="btn btn-success btn-admin" data-toggle="modal" data-target="#createHelpCenter" @click="create()">añadir</button>
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
                        <p>Titulo</p>
                    </div>
                    <div class="content_title__item ml-auto mr-12">
                        <p>Acciones</p>
                    </div>
                </div>
                    <div class="grid__product">
                        <div class="card" v-for="helpCenter in helpCenters">
                            <div class="card-body">
                                <p class="">
                                @{{ helpCenter.title }}
                                </p>
                                <button class="btn btn-success" @click="edit(helpCenter)" data-toggle="modal" data-target="#createHelpCenter"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-danger" @click="erase(helpCenter.id)"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
       

            </div>
        </div>
    </div>

    <!-- Create Modal -->

    <div class="modal fade" id="createHelpCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Centro de ayuda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Titulo</label>
                        <input type="text" class="form-control" v-model="title">
                    </div>
                    <div class="form-group">
                        <label for="name">Texto</label>
                        <textarea class="form-control" v-model="description" rows="5"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="store()" v-if="isEdit == false">Save changes</button>
                    <button type="button" class="btn btn-primary" @click="update()" v-if="isEdit == true">Save changes</button>
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
                    helpCenters:[],
                    description:"",
                    title:"",
                    helpCenterId:"",
                    isEdit:false,
                    pages:0,
                    page:1
                }
            },
            methods:{
                
                store(){

                    axios.post("{{ url('admin/help-center/store') }}", {title: this.title, description: this.description})
                    .then(res => {
                        
                        if(res.data.success == true){

                            alert(res.data.msg)
                            this.title = ""
                            this.description = ""
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

                    axios.post("{{ url('admin/help-center/update') }}", {title: this.title, description: this.description, id: this.helpCenterId})
                    .then(res => {
                        
                        if(res.data.success == true){

                            alert(res.data.msg)
                            this.title = ""
                            this.description = ""
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
                edit(helpCenter){
                    
                    this.title = helpCenter.title
                    this.description = helpCenter.description
                    this.helpCenterId = helpCenter.id
                    this.isEdit = true

                },
                create(){
                    this.title = ""
                    this.description = ""
                    this.helpCenterId = ""
                    this.isEdit = false
                },
                fetch(){

                    axios.get("{{ url('/admin/help-center/fetch') }}")
                    .then(res => {

                        if(res.data.success == true){
                            this.helpCenters = res.data.helpCenters
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

                        axios.post("{{ url('admin/help-center/delete') }}", {id: id})
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