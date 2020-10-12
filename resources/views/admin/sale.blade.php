@extends('layouts.admin')

@section('content')

    @include('partials.admin.navbar')

    <div class="container content__admin">

        <div class="row">
            <div class="col-12">
                <p class="text-center">
                    <button class="btn btn-info" data-toggle="modal" data-target="#export">
                        <i class="fa fa-download"></i>
                    </button>
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-md-8 offset-md-2 col-12">

                <div class="card" v-for="sale in sales">
                    <div class="card-body">
                        <p class="text-center" v-if="sale.user">
                            user: @{{ sale.user.name }}
                        </p>
                        <p class="text-center" v-if="sale.user">
                            email: @{{ sale.user.email }}
                        </p>
                        

                        <p class="text-center" v-if="sale.guest">
                            user: @{{ sale.guest.name }}
                        </p>
                        <p class="text-center" v-if="sale.guest">
                            email: @{{ sale.guest.email }}
                        </p>
                        
                        <p class="text-center">
                            status: <span v-if="sale.status == 'aprovado'">Aprobado</span><span v-else>Rechazado</span>
                            Fecha: @{{ sale.created_at.toString().substring(0, 10) }}
                        </p>
                        <p class="text-center">
                            <button class="btn btn-success" @click="getProductDetails(sale.product_purchase, sale)" data-toggle="modal" data-target="#details">
                                Detalles
                            </button>
                        </p>
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
                            <div class="col-4">
                                <p><strong>Tipo de usuario</strong></p>
                                <p v-if="saleDetails.user">Registrado</p>
                                <p v-if="saleDetails.guest">Invitado</p>
                            </div>
                            <div class="col-4">
                                <p><strong>Tipo de facturación</strong></p>
                                <p>@{{ saleDetails.ticket_type }}</p>
                            </div>
                            <div class="col-4" v-if="saleDetails.user">
                                <p><strong>Nombre</strong></p>
                                <p>@{{ saleDetails.user.name }}</p>
                            </div>
                            <div class="col-4" v-if="saleDetails.user">
                                <p><strong>Rut</strong></p>
                                <p>@{{ saleDetails.user.rut }}</p>
                            </div>
                            <div class="col-4" v-if="saleDetails.user">
                                <p><strong>Celular</strong></p>
                                <p>@{{ saleDetails.user.phone_number }}</p>
                            </div>
                            <div class="col-4" v-if="saleDetails.user">
                                <p><strong>Email</strong></p>
                                <p>@{{ saleDetails.user.email }}</p>
                            </div>
                            <div class="col-4" v-if="saleDetails.user">
                                <p><strong>Región</strong></p>
                                <p>@{{ saleDetails.user.location.name }}</p>
                            </div>
                            <div class="col-4" v-if="saleDetails.user">
                                <p><strong>Comuna</strong></p>
                                <p>@{{ saleDetails.user.commune.name }}</p>
                            </div>
                            <div class="col-4" v-if="saleDetails.user">
                                <p><strong>Calle</strong></p>
                                <p>@{{ saleDetails.user.street }}</p>
                            </div>
                            <div class="col-4" v-if="saleDetails.user">
                                <p><strong>Número</strong></p>
                                <p>@{{ saleDetails.user.number }}</p>
                            </div>
                            <div class="col-4" v-if="saleDetails.user">
                                <p><strong>Dept / Casa /oficina</strong></p>
                                <p>@{{ saleDetails.user.house }}</p>
                            </div>
                            <div class="col-4" v-if="saleDetails.user && saleDetails.ticket_type == 'factura'">
                                <p><strong>Razón social empresa</strong></p>
                                <p>@{{ saleDetails.user.business_name }}</p>
                            </div>
                            <div class="col-4" v-if="saleDetails.user && saleDetails.ticket_type == 'factura'">
                                <p><strong>RUT empresa</strong></p>
                                <p>@{{ saleDetails.user.business_rut }}</p>
                            </div>
                            <div class="col-4" v-if="saleDetails.user && saleDetails.ticket_type == 'factura'">
                                <p><strong>Dirección empresa</strong></p>
                                <p>@{{ saleDetails.user.business_address }}</p>
                            </div>
                            <div class="col-4" v-if="saleDetails.user && saleDetails.ticket_type == 'factura'">
                                <p><strong>Teléfono empresa</strong></p>
                                <p>@{{ saleDetails.user.business_phone }}</p>
                            </div>
                            <div class="col-4" v-if="saleDetails.user && saleDetails.ticket_type == 'factura'">
                                <p><strong>Correo empresa</strong></p>
                                <p>@{{ saleDetails.user.business_mail }}</p>
                            </div>
                            <div class="col-4" v-if="saleDetails.guest">
                                <p><strong>Nombre</strong></p>
                                <p>@{{ saleDetails.guest.name }}</p>
                            </div>
                            <div class="col-4" v-if="saleDetails.guest">
                                <p><strong>Rut</strong></p>
                                <p>@{{ saleDetails.guest.rut }}</p>
                            </div>
                            <div class="col-4" v-if="saleDetails.guest">
                                <p><strong>Celular</strong></p>
                                <p>@{{ saleDetails.guest.phone }}</p>
                            </div>
                            <div class="col-4" v-if="saleDetails.guest">
                                <p><strong>Email</strong></p>
                                <p>@{{ saleDetails.guest.email }}</p>
                            </div>
                            <div class="col-4" v-if="saleDetails.guest">
                                <p><strong>Región</strong></p>
                                <p>@{{ saleDetails.guest.location.name }}</p>
                            </div>
                            <div class="col-4" v-if="saleDetails.guest">
                                <p><strong>Comuna</strong></p>
                                <p>@{{ saleDetails.guest.commune.name }}</p>
                            </div>
                            <div class="col-4" v-if="saleDetails.guest">
                                <p><strong>Calle</strong></p>
                                <p>@{{ saleDetails.guest.street }}</p>
                            </div>
                            <div class="col-4" v-if="saleDetails.guest">
                                <p><strong>Número</strong></p>
                                <p>@{{ saleDetails.guest.number }}</p>
                            </div>
                            <div class="col-4" v-if="saleDetails.guest">
                                <p><strong>Dept / Casa /oficina</strong></p>
                                <p>@{{ saleDetails.guest.house }}</p>
                            </div>
                            
                            
                        </div>
                    </div>

                    <div>
                        <p class="text-center"><strong>Total: </strong>@{{ parseInt(total).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</p>
                    </div>

                    <div class="text-center" v-if="saleDetails.created_at">
                        <strong>Fecha:</strong> @{{ saleDetails.created_at.toString().substring(0, 10) }}
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Tipo de envío </th>
                                <th>Costo de envío </th>
                            </tr>
                        </thead>
                        <tbody>
                            {{--<tr v-for="(productDetail, index) in productDetails">
                                <td>
                                    @{{ index + 1 }}
                                </td>
                                <td>
                                    @{{ productDetail.product.name }}
                                </td>
                                <td>
                                    @{{ productDetail.amount }}
                                </td>
                                <td>
                                    @{{ parseInt(productDetail.price).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}
                                </td>
                                <td>
                                    @{{ productDetail.shipping_method }}
                                </td>
                                <td>
                                    @{{ parseInt(productDetail.shipping_cost).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}
                                </td>
                            </tr>--}}
                        </tbody>
                    </table>                
                

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Details Modal -->

    <!-- export Modal -->

    <div class="modal fade" id="export" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Exportar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="fromDate">Desde</label>
                                    <input type="date" class="form-control" v-model="fromDate">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="toDate">Hasta</label>
                                    <input type="date" class="form-control" v-model="toDate">
                                </div>
                            </div>
                            <div class="col-12">
                                <p class="text-center">
                                    <button class="btn btn-success" @click="exportExcel()">Exportar</button>
                                </p>
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


    <!-- export Modal -->

@endsection

@push('scripts')
    
    <script>
        
        const app = new Vue({
            el: '#dev-app',
            data(){
                return{
                    modalTitle:"Detalles",
                    productDetails:[],
                    saleDetails:[],
                    pages:0,
                    page:1,
                    sales:[],
                    fromDate:"",
                    toDate:"",
                    total:0
                }
            },
            methods:{
            
                getProductDetails(details, sale){
                    this.productDetails = details
                    this.saleDetails = sale

                    this.productDetails.forEach((data, index) => {

                        this.total = data.price + data.shipping_cost

                    })

                },
                fetch(page = 1){

                    axios.post("{{ route('admin.sale.fetch') }}", {page: page})
                    .then(res => {
                        
                        this.pages = Math.ceil(res.data.salesCount / 10)
                        this.sales = res.data.sales

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value){
                            alert(value)
                        });
                    })

                },
                exportExcel(){

                    window.open("{{ url('/admin/sales/export/') }}"+"/"+this.fromDate+"/to/"+this.toDate)

                }


            },
            mounted(){
                //this.getProduct()
                this.fetch()
            }

        })
    
    </script>

@endpush