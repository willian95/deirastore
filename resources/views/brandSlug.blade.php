@extends('layouts.main')

@section('content')

    @include('partials.navbar')

    <div class="container">
        <div class="row">
            <div class="col-3" v-for="product in products">
                <div class="main-slider__item">
                    <a :href=" '{{ url('/') }}' + '/product/' + product.slug">
                        <div class="content-slider">
                            <img :src="'{{ url('/') }}' + '/images/products/' +product.picture" alt="" v-if="product.external == false">
                            <img :src="product.picture" style="width: 100%;" alt="" v-else>
                        </div>
                        <div class="main-slider__text">
                            <span>@{{ product.name }}</span>
                            <p class="title">@{{ product.category.name }}</p>
                            <span class="price" v-if="product.external_price > 0">$ @{{ ParseInt(product.external_price * dolarPrice }}</span>
                            <span class="price" v-else>$ @{{ product.price }}</span>
                            <p v-if="product.sub_price > 0" class="price-old">Normal <span>$ @{{ product.sub_price }}</span></p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="#" v-for="index in pages" :key="index" @click="fetch(index)" >@{{ index }}</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>


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

                axios.post("{{ route('brands.products') }}", {page: page, slug: this.slug})
                .then(res => {

                    if(res.data.success == true){
                        this.pages = Math.ceil(res.data.productsCount / 10)
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