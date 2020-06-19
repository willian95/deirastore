@extends('layouts.main')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-md-8 offset-md-2 col-12">

            <div class="card" v-for="purchase in purchases">
                    <div class="card-body">
                        <p class="text-center">
                            status: @{{ purchase.status }}
                        </p>
                        <p class="text-center">
                            <button class="btn btn-success" @click="getProductDetails(purchase.product_purchase)" data-toggle="modal" data-target="#details">
                                ver detalles
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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detalles de compra</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Amount</th>
                                <th>Price</th>
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
                                    @{{ productDetail.product.price }}
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

    @include('partials.footer')

@endsection

@push('scripts')
    
    <script>
        
        const app = new Vue({
            el: '#dev-app',
            data(){
                return{
                    productDetails:[],
                    pages:0,
                    purchases:[],
                    page:1
                }
            },
            methods:{
                getProductDetails(details){
                    this.productDetails = details
                },
                fetch(page = 1){

                    this.page = page

                    axios.post("{{ route('user.purchase.fetch') }}", {page: page})
                    .then(res => {
                        
                        this.pages = Math.ceil(res.data.purchasesCount / 10)
                        this.purchases = res.data.purchases

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value){
                            alertify.error(value)
                        });
                    })

                }


            },
            mounted(){
                this.fetch()
            }

        })
    
    </script>

@endpush