@extends('layouts.main')

@section('content')

    <div class="container bg" id="search-view">
       <!---- <div class="row">
            <div class="col-12">
                <a class="btn btn-primary btn-general btn-general--form" style="color: #fff;" href="{{ url()->previous() }}"><i class="fa fa-arrow-left"></i></a>
            </div>
        </div>--->
        <div class="row">
            <div class="col-12">
                <div class="title__general title__general-start">
                    <p><strong>Resultado de:</strong> @{{ searchText }}</p>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-3" v-for="product in products">
                <div class="main-slider__item">
                    <a :href="'{{ url('/product/') }}'+'/'+product.slug">
                        <div class="content-slider">
                            
                            <img style="width: 100%;" :src="product.picture" alt="" v-if="product.is_external == true">
                        
                            <img style="width: 100%;" :src="'{{ asset('/images/products/') }}'+'/'+product.image" alt="" v-else>
                           
                        </div>
                        <div class="main-slider__text">
                            <span>@{{ product.name }}</span>
                            <p class="title" v-if="product.category">@{{ product.category.name }}</p>
                        
                            
                        </div>
                    </a>
                </div>
            </div>

      
        </div>

        <div class="row">
            <div class="col-12">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li>
                            <a class="page-link" v-if="page > 1" href="#" @click="search(page - 1)">Anterior</a>
                        </li>
                        <li class="page-item" v-for="index in pages">
                            <a class="page-link" href="#" v-if="index >= page &&  index < page + 6"  :key="index" @click="search(index)" >@{{ index }}</a>
                        </li>
                        <li>
                            <a class="page-link" v-if="page < pages" href="#" @click="search(page + 6)">Siguiente</a>
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
                    pages:0,
                    page:1
                }
            },
            methods:{
                
                search(page = 1){

                    this.page = page

                    axios.post("{{ url('/search') }}", {search: this.searchText, page: this.page}).then(res => {

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