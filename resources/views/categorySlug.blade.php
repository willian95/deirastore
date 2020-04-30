@extends('layouts.main')

@section('content')

    @include('partials.navbar')

    <div class="container">
        <div class="title__general title__general-start">
            <p><strong>{{ $category->name }}</strong></p>
        </div>
        <div class="row">
            <div class="col-3" v-for="product in products">
                <div class="main-slider__item">
                    <a :href=" '{{ url('/') }}' + '/product/' + product.slug">
                        <div class="content-slider">
                            <img :src="'{{ url('/') }}' + '/images/products/' +product.picture" alt="" v-if="product.is_external == false" style="width: 100%">
                            <img :src="product.picture" alt="" v-else style="width: 100%">
                        </div>
                        <div class="main-slider__text">
                            <span>@{{ product.name }}</span>
                            <p class="title">@{{ product.category.name }}</p>
                            <span class="price" v-if="product.external_price > 0">$ @{{ parseInt(dolarPrice * product.external_price).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</span>
                            <span class="price" v-else>$ @{{ product.price }}</span>
                            <p class="price-old" v-if="product.sub_price > 0">Normal <span>$ @{{ product.sub_price }}</span></p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <nav aria-label="Page navigation example" style="margin-top: 10px;">
                    <ul class="pagination">
                        <li class="page-item" v-for="index in pages">
                            <a class="page-link" href="#"  :key="index" @click="fetch(index)" >@{{ index }}</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    @include('partials.footer')

@endsection

@push('scripts')

<script>
        
    const app = new Vue({
        el: '#dev-app',
        data(){
            return{
                slug:'{!! $slug !!}',
                products:[],
                pages:0,
                dolarPrice: '{!! App\DolarPrice::first()->price !!}'
            }
        },
        methods:{
            
            fetch(page = 1){

                axios.post("{{ route('category.products') }}", {page: page, slug: this.slug})
                .then(res => {

                    if(res.data.success == true){
                        this.pages = Math.ceil(res.data.productsCount / 20)
                        this.products = res.data.products
                    }else{

                        alert(res.data.msg)

                    }

                })
                .catch(err => {
                    console.log(err.response.data)
                })

            },

        },
        mounted(){
            this.fetch()
        }

    })

</script>

@endpush