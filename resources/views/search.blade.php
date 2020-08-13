@extends('layouts.main')

@section('content')

    <div class="container bg" id="search-view">
       <!---- <div class="row">
            <div class="col-12">
                <a class="btn btn-primary btn-general btn-general--form" style="color: #fff;" href="{{ url()->previous() }}"><i class="fa fa-arrow-left"></i></a>
            </div>
        </div>--->
        <div class="row" v-cloak>
            <div class="col-12">
                <div class="title__general title__general-start fadeInUp wow animated pag-center">
                    <p><strong>Resultado de:</strong> @{{ searchText }}</p>
                    <div class="row">
                        <div class="col-12">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="line-pag">
                                        <a class="page-link" href="#" v-if="page > 1" @click="search(1)">Primero</a>
                                    </li>
                                    <li class="line-pag line-pag_r" >
                                        <a class="page-link" v-if="page > 1" href="#" @click="search(page - 1)"><i class="fa fa-long-arrow-left" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                    <li class="page-item" v-for="index in pages">
                                        <a class="page-link" style="background-color: #d32b2b; color: #fff !important;" href="#" v-if="page == index && index >= page - 3 &&  index < page + 3"  :key="index" @click="search(index)" >@{{ index }}</a>
                                        <a class="page-link" href="#" v-if="page != index && index >= page - 3 &&  index < page + 3"  :key="index" @click="search(index)" >@{{ index }}</a> 
                                    </li>
                                    <li class="line-pag">
                                        <a class="page-link" v-if="page < pages" href="#" @click="search(page + 1)"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                    <li class="line-pag">
                                        <a class="page-link" href="#" v-if="page < pages" @click="search(pages)">último</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" v-cloak>
            <div class="col-md-4 col-lg-3">
                <div class="form-group">
                    <label for="">Ordernar por:</label>
                    <select class="form-control" v-model="filterOrder" @change="search()">
                        <option value="1">Nombre A - Z</option>
                        <option value="2">Nombre Z - A</option>
                        <option value="3">Precio Menor - Mayor</option>
                        <option value="4">Precio Mayor - Menor</option>
                        <option value="5">Stock Menor - Mayor</option>
                        <option value="6">Stock Mayor - Menor</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row" v-cloak>

            <div class="col-md-3" v-for="product in products">
                <div class="main-slider__item">
                    <a :href="'{{ url('/product/') }}'+'/'+product.slug">
                        <div class="content-slider">
                            
                            <img style="width: 100%;" :src="product.picture" alt="" >
                           
                        </div>
                        <div class="main-slider__text">
                            <span>@{{ product.name }}</span>
                            <p class="title-brand">@{{ product.brand.name }}</p>
                            <p class="title" v-if="product.category">@{{ product.category.name }}</p>
                            <span class="price" v-if="product.percentage_range_profit > 0 && product.percentage_range_profit != null">$ @{{ parseInt((dolarPrice * product.price_range_profit) + 1).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</span>
                            <span class="price" v-else>$ @{{  parseInt((dolarPrice * product.external_price) + 1).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</span>
                            <!--<span class="price" v-if="product.external_price > 0">$ @{{ parseInt((product.external_price * dolarPrice) + 1).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</span>
                            <span class="price" v-else>$ @{{ product.price }}</span>-->
                            
                        </div>
                    </a>
                </div>
            </div>

      
        </div>

        <div class="row" v-cloak>
            <div class="col-12">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="line-pag">
                            <a class="page-link" href="#" v-if="page > 1" @click="search(1)">Primero</a>
                        </li>
                        <li class="line-pag line-pag_r" >
                            <a class="page-link" v-if="page > 1" href="#" @click="search(page - 1)"><i class="fa fa-long-arrow-left" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="page-item" v-for="index in pages">
                            <a class="page-link" style="background-color: #d32b2b; color: #fff !important;" href="#" v-if="page == index && index >= page - 3 &&  index < page + 3"  :key="index" @click="search(index)" >@{{ index }}</a>
                            <a class="page-link" href="#" v-if="page != index && index >= page - 3 &&  index < page + 3"  :key="index" @click="search(index)" >@{{ index }}</a> 
                        </li>
                        <li class="line-pag">
                            <a class="page-link" v-if="page < pages" href="#" @click="search(page + 6)"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="line-pag">
                            <a class="page-link" href="#" v-if="page < pages" @click="search(pages)">último</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        

    </div>

    @include('partials.footer')

@endsection

@push("scripts")

    <script>

        const searchView = new Vue({
            el: '#search-view',
            data(){
                return{
                    searchText:"",
                    products:[],
                    dolarPrice: '{!! App\DolarPrice::first()->price !!}',
                    filterOrder:"1",
                    pages:0,
                    page:1
                }
            },
            methods:{
                
                search(page = 1){

                    this.page = page

                    axios.post("{{ url('/search') }}", {search: this.searchText, page: this.page, filterOrder: this.filterOrder}).then(res => {

                        //console.log("test-products", res)
                        this.products = res.data.products
                        this.pages = Math.ceil(res.data.productsCount / 20)

                    })

                }

            },
            mounted(){
                if(localStorage.getItem("search") != null){
                    this.searchText = localStorage.getItem("search")
                    this.search()
                }
            }

        }) 

    </script>

@endpush