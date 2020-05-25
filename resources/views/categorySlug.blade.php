@extends('layouts.main')

@section('content')

    <div class="container bg">
        <div class="col-12">
            <a class="btn btn-primary btn-general btn-general--form" style="color: #fff;" href="{{ url()->previous() }}"><i class="fa fa-arrow-left"></i></a>
        </div>
        <div class="title__general title__general-start">
            <p><strong>{{ $category->name }}</strong></p>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-3" v-for="product in products">
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
                        <li>
                            <a class="page-link" v-if="page > 1" href="#" @click="fetch(page - 1)">Anterior</a>
                        </li>
                        <li class="page-item" v-for="index in pages">
                            <a class="page-link" href="#" v-if="index > page &&  index < page + 6"  :key="index" @click="fetch(index)" >@{{ index }}</a>
                        </li>
                        <li>
                            <a class="page-link" v-if="page < pages" href="#" @click="fetch(page + 6)">Siguiente</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="row" v-if="subCategories.length > 0">
            <div class="col-12">
                <div class="title__general title__general-start">
                    <p><strong>Sub-categorías</strong></p>
                </div>
            </div>
        </div>

        <div class="row" style="margin-bottom: 20px;">
            <div class="col-12 col-md-6 col-lg-3" v-for="subCategory in subCategories">
                <div class="main-slider__item">
                    <a :href=" '{{ url('/') }}' + '/category/' + subCategory.slug">
                        <div class="content-slider">
                            <img :src="'{{ url('/') }}' + '/assets/images/categories/' +subCategory.picture" alt="" v-if="subCategory.image != null" style="width: 100%">
                            <img :src="'{{ url('/') }}' + '/images/categories/default.png'" alt="" v-else style="width: 100%">
                        </div>
                        <div class="main-slider__text">
                            <span>@{{ subCategory.name }}</span>
                        </div>
                    </a>
                </div>
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
                subCategories:[],
                pages:0,
                dolarPrice: '{!! App\DolarPrice::first()->price !!}',
                page:1
            }
        },
        methods:{
            
            fetch(page = 1){

                this.page = page

                axios.post("{{ route('category.products') }}", {page: page, slug: this.slug})
                .then(res => {

                    if(res.data.success == true){
                        this.pages = Math.ceil(res.data.productsCount / 20)
                        this.products = res.data.products
                        this.subCategories = res.data.subCategories
                    }else{

                        alertify.error(res.data.msg)

                    }

                })
                .catch(err => {
                    alertify.error("Error en el servidor")
                    //console.log(err.response.data)
                })

            }


        },
        mounted(){
            this.fetch()
        }

    })

</script>

@endpush