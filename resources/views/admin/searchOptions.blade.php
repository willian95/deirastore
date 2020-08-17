@extends('layouts.admin')

@section('content')

    @include('partials.admin.navbar')
    <div class="container content__admin">
        <div class="loader-cover-custom" v-if="loading == true">
            <div class="loader-custom"></div>
        </div>
        <div class="row">
            <div class="col-md-12">

                <table class="table">
                    <thead>
                        <tr>
                            <th><strong>#</strong></th>
                            <th><strong>Nombre</strong></th>
                            <th><strong>Posición Actual</strong></th>
                            <th><strong>Acciones</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(category, index) in categories">
                            <td>@{{ index + 1 }}</td>
                            <td v-if="category.esp_name != null">@{{ category.esp_name }}</td>
                            <td v-else>@{{ category.name }}</td>
                            <td>
                                @{{ category.search_position }}
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-8">
                                        <select class="form-control" :id="'category'+category.id">
                                            <option value=""></option>
                                            <option :value="index + 1" v-for="(category, index) in categories">@{{ index + 1 }}</option>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <button class="btn btn-success" @click="update(category.id)">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            
            </div>
        </div>
    </div>

@endsection

@push("scripts")

    <script>
        const app = new Vue({
            el: '#dev-app',
            data(){
                return{
                    categories:[],
                    loading:false
                }
            },
            methods:{
                
                fetchCategories(){
                   
                    this.loading = true
                    axios.get("{{ url('/categories/all') }}")
                    .then(res => {
                        //console.log(res)
                        this.loading = false
                        if(res.data.success == true){
                           this.categories = res.data.categories

                        }else{

                            alertify.error(res.data.msg)

                        }

                    })
                    
                },
                update(categoryId){

                    this.loading = true

                    let position = $("#category"+categoryId).val()
                    if(position != null){
                        axios.post("{{ url('admin/search/options/update') }}", {categoryId: categoryId, position: position})
                        .then(res => {
                            //console.log(res)
                            this.loading = false
                            if(res.data.success == true){
                                alertify.success(res.data.msg)
                                this.fetchCategories()
                            }else{

                                alertify.error(res.data.msg)

                            }

                        })
                    }else{
                        alertify.error("Debes elegir una categoría")
                    }

                }

            },
            mounted(){
                this.fetchCategories()

            }

        })
    </script>

@endpush