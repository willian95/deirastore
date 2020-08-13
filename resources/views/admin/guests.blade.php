@extends('layouts.admin')

@section('content')

    @include('partials.admin.navbar')

    <div class="container content__admin">

        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center">Usuarios Invitados</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                
                                    <th><strong>Nombre</strong></th>
                                    <th><strong>Apellido</strong></th>
                                    <th><strong>RUT</strong></th>
                                    <th><strong>Detalles</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(user, index) in users">
                                    <td>@{{ user.name }}</td>
                                    <td>@{{ user.lastname }}</td>
                                    <td>@{{ user.rut }}</td>
                                    <td>
                                        <button class="btn btn-info" @click="getUserDetails(user)" data-toggle="modal" data-target="#details">
                                            <i class="fa fa-eye"></i>
                                        </button>
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

    <!-- Details Modal -->

    <div class="modal fade" id="details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@{{ modalTitle }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="container-fluid">
                        <div class="row">
                            
                            <div class="col-4" v-if="userDetails != null">
                                <p><strong>Nombre</strong></p>
                                <p>@{{ userDetails.name }}</p>
                            </div>
                            <div class="col-4" v-if="userDetails != null">
                                <p><strong>Rut</strong></p>
                                <p>@{{ userDetails.rut }}</p>
                            </div>
                            <div class="col-4" v-if="userDetails != null">
                                <p><strong>Celular</strong></p>
                                <p>@{{ userDetails.phone_number }}</p>
                            </div>
                            <div class="col-4" v-if="userDetails != null">
                                <p><strong>Email</strong></p>
                                <p>@{{ userDetails.email }}</p>
                            </div>
                            <div class="col-4" v-if="userDetails != null && userDetails.location">
                                <p><strong>Región</strong></p>
                                <p>@{{ userDetails.location.name }}</p>
                            </div>
                            <div class="col-4" v-if="userDetails != null && userDetails.commune">
                                <p><strong>Comuna</strong></p>
                                <p>@{{ userDetails.commune.name }}</p>
                            </div>
                            <div class="col-4" v-if="userDetails != null">
                                <p><strong>Calle</strong></p>
                                <p>@{{ userDetails.street }}</p>
                            </div>
                            <div class="col-4" v-if="userDetails != null">
                                <p><strong>Número</strong></p>
                                <p>@{{ userDetails.number }}</p>
                            </div>
                            <div class="col-4" v-if="userDetails != null">
                                <p><strong>Dept / Casa /oficina</strong></p>
                                <p>@{{ userDetails.house }}</p>
                            </div>
                            
                        </div>
                    </div>              
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Details Modal -->

@endsection

@push('scripts')
    
    <script>
        
        const app = new Vue({
            el: '#dev-app',
            data(){
                return{
                    modalTitle:"Detalles",
                    userDetails:null,
                    pages:0,
                    page:1,
                    users:[]
                }
            },
            methods:{
            
                getUserDetails(user){
                    this.userDetails = user
                },
                fetch(page = 1){
                    this.page = page
                    axios.get("{{ url('admin/users/guest/fetch/') }}"+"/"+page)
                    .then(res => {
                        
                        this.pages = Math.ceil(res.data.usersCount / 20)
                        this.users = res.data.users

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value){
                            alert(value)
                        });
                    })

                }


            },
            mounted(){
                //this.getProduct()
                this.fetch()
            }

        })
    
    </script>

@endpush