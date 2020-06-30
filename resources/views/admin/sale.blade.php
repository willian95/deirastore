@extends('layouts.admin')

@section('content')

    @include('partials.admin.navbar')

    <div class="container content__admin">
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
                        <p class="text-center" v-if="sale.user">
                            dirección: @{{ sale.user.address }}
                        </p>

                        <p class="text-center" v-if="sale.guest">
                            user: @{{ sale.guest.name }}
                        </p>
                        <p class="text-center" v-if="sale.guest">
                            email: @{{ sale.guest.email }}
                        </p>
                        <p class="text-center" v-if="sale.guest">
                            dirección: @{{ sale.guest.address }}
                        </p>
                        <p class="text-center" v-if="sale.guest">
                            status: <span v-if="sale.status == 'aprovado'">Aprobado</span><span v-else>Rechazado</span>
                        </p>
                        <p class="text-center">
                            <button class="btn btn-success" @click="getProductDetails(sale.product_purchase)" data-toggle="modal" data-target="#details">
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
                            <tr v-for="(productDetail, index) in productDetails">
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
                                    @{{ productDetail.price }}
                                </td>
                                <td>
                                    @{{ productDetail.shipping_method }}
                                </td>
                                <td>
                                    @{{ productDetail.shipping_cost }}
                                </td>
                            </tr>
                        </tbody>
                    </table>                
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                    productDetails:[],
                    pages:0,
                    page:1,
                    sales:[]
                }
            },
            methods:{
            
                getProductDetails(details){
                    this.productDetails = details
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

                }


            },
            mounted(){
                //this.getProduct()
                this.fetch()
            }

        })
    
    </script>

@endpush