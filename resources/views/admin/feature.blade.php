@extends('layouts.admin')

@section('content')

    @include('partials.admin.navbar')

    <div class="container content__admin">
        <div class="row" style="margin-top: 120px;">
            <div class="col-12">
                <h3 class="text-center">Tabla de Características</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <p class="text-center">
                    <button class="btn btn-success" data-target="#featureModal" data-toggle="modal">+</button>
                </p>
            </div>
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>
                                #
                            </th>
                            <th>
                                Característica
                            </th>
                            <th>
                                Descripción
                            </th>
                            <th>
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(feature, index) in features">
                            <td>
                                @{{ index + 1 }}
                            </td>
                            <td>
                                @{{ feature.feature }}
                            </td>
                            <td>
                                @{{ feature.description }}
                            </td>
                            <td>
                                <button class="btn btn-info" @click="edit(feature)" data-target="#featureModal" data-toggle="modal"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-secondary" @click="erase(feature.id)"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="featureModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Características</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Característica</label>
                        <input type="text" class="form-control" v-model="feature">
                    </div>
                    <div class="form-group">
                        <label for="">Descripción</label>
                        <textarea v-model="description" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="modalClose">Cerrar</button>
                    <button type="button" class="btn btn-primary" @click="store()" v-if="action == 'create'">Guardar</button>
                    <button type="button" class="btn btn-primary" @click="update()" v-if="action == 'edit'">Actualizar</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('scripts')

    <script>
        const app = new Vue({
            el: '#dev-app',
            data() {
                return {
                    featureId:"",
                    features:[],
                    productId:"{{ $id }}",
                    feature:"",
                    description:"",
                    action:"create"
                }
            },
            methods: {

                create(){
                    this.featureId = ""
                    this.feature = ""
                    this.action = "create"
                    this.description = ""
                },
                edit(feature){
                    this.featureId = feature.id
                    this.feature = feature.feature
                    this.description = feature.description
                    this.action = "edit"
                },
                fetch(){

                    axios.get("{{ url('/admin/feature/fetch/') }}"+"/"+this.productId).then(res => {

                        this.features = res.data.features

                    })

                },
                store(){

                    axios.post("{{ url('/admin/feature/store') }}", {"feature": this.feature, "description": this.description, "product_id": this.productId}).then(res => {

                        if(res.data.success == true){

                            this.feature = ""
                            this.description = ""
                            this.featureId = ""
                            this.action = "create"

                            $("#modalClose").click();
                            $('body').removeClass('modal-open');
                            $('body').css('padding-right', '0px');
                            $('.modal-backdrop').remove();

                            alertify.success(res.data.msg)
                            this.fetch()
                        }else{
                            alertify.error(res.data.msg)
                        }

                    })

                },
                update(){

                    axios.post("{{ url('/admin/feature/update') }}", {"feature": this.feature, "description": this.description, "id": this.featureId}).then(res => {

                        if(res.data.success == true){

                            this.feature = ""
                            this.description = ""
                            this.featureId = ""
                            this.action = "create"

                            $("#modalClose").click();
                            $('body').removeClass('modal-open');
                            $('body').css('padding-right', '0px');
                            $('.modal-backdrop').remove();

                            alertify.success(res.data.msg)
                            this.fetch()
                        }else{
                            alertify.error(res.data.msg)
                        }

                    })

                },
                erase(id){

                    axios.post("{{ url('/admin/feature/delete') }}", {"id": id}).then(res => {

                        if(res.data.success == true){

                            this.action = "create"

                            alertify.success("Característica agregada")
                            this.fetch()
                        }else{
                            alertify.error(res.data.msg)
                        }

                    })

                }

            },
            mounted() {
                //this.test()
                this.fetch()
            }

        })
    </script>

@endpush