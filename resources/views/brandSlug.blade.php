@extends('layouts.main')

@section('content')

    <div class="container bg">





        <div class="title__general title__general-start fadeInUp wow animated pag-center">
            <p><strong>{{ $brand->name }}</strong></p>

            
        <div class="row">
            <div class="col-12">
                <nav aria-label="Page navigation example">
                    <ul class="pagination" style="margin-top: 15px;">
                        <li>
                            <a class="page-link" v-if="page > 1" href="#" @click="fetch(page - 1)">Anterior</a>
                        </li>
                        <li class="page-item" v-for="index in pages">
                            <a class="page-link" href="#" v-if="index >= page &&  index < page + 6"  :key="index" @click="fetch(index)" >@{{ index }}</a>
                        </li>
                        <li>
                            <a class="page-link" v-if="page < pages" href="#" @click="fetch(page + 6)">Siguiente</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-xs-12 " v-for="product in products">
                <div class="main-slider__item">
                    <a :href=" '{{ url('/') }}' + '/product/' + product.slug">
                        <div class="content-slider">
                            <img :src="'{{ url('/') }}' + '/images/products/' +product.picture" alt="" v-if="product.is_external == false">
                            <img :src="product.picture" style="width: 100%;" alt="" v-if="product.is_external == true && product.data_source_id == 1">
                            <img :src="product.picture" style="width: 100%;" alt="" v-if="product.data_source_id == 2">
                        </div>
                        <div class="main-slider__text">
                            <p class="title" >@{{ product.name }}</p>
                            <p class="title-brand">@{{ product.brand.name }}</p>
                            <span v-if="product.category">@{{ product.category.name }}</span>
                            <span class="price" v-if="product.external_price > 0">$ @{{ parseInt((product.external_price * dolarPrice) + 1).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</span>
                            <span class="price" v-else>$ @{{ product.price }}</span>
                            <!--<p v-if="product.sub_price > 0" class="price-old">Normal <span>$ @{{ product.sub_price }}</span></p>-->
                        </div>
                    </a>
                </div>
            </div>
        </div>
     
        <div class="row">

            @foreach(App\Banner::where('size', 'large')->where('location', $slug)->get() as $banner)

                @php
                    $float = "";
                    if($banner->position == "izquierda"){
                        $float = "left";
                    }else{
                        $float = "right";
                    }

                @endphp

                <div class="col-12">
                    <!--<div class="main-banner">-->
                        <div class="main-banner__card-img">
                            <img src="{{ asset('/images/banners/'.$banner->image) }}" alt="" style="width: 100%;">
                            <!--<div class="main-banner__content">-->
                                <div class="title" style="text-align: {{ $float }};">
                                    <h3 style="color: {{ $banner->title_color }}">{{ $banner->title }}</h3>
                                    <p style="color: {{ $banner->text_color }}">{{ $banner->text }}</p>
                                    @if($banner->link != "" || $banner->button_text != "")
                                    <a href="{{ $banner->link }}" target="_blank" class="btn-general" style="color: {{ $banner->button_color }}; background-color: {{ $banner->button_text_color }};">{{ $banner->button_text }}</a>
                                    @endif
                                </div>
                            <!--</div>-->
                        </div>


                    <!--</div>-->
                </div>
            @endforeach

        </div>


        <div class="row">
        @foreach(App\Banner::where('size', 'medium')->where('location', $slug)->get() as $banner)

            @php
                $float = "";
                if($banner->position == "izquierda"){
                    $float = "left";
                }else{
                    $float = "right";
                }

            @endphp

            <div class="col-md-6">
                <div class="main-banner__card-img">
                    <img src="{{ asset('/images/banners/'.$banner->image) }}" alt="" style="width: 100%;">
                    <div class="title" style="text-align: {{ $float }};">
                        <h3 style="color: {{ $banner->title_color }}">{{ $banner->title }}</h3>
                        <p style="color: {{ $banner->text_color }}">{{ $banner->text }}</p>
                        @if($banner->link != "" && $banner->button_text != "")
                            <a href="{{ $banner->link }}" target="_blank" class="btn-general" style="color: {{ $banner->button_color }}; background-color: {{ $banner->button_text_color }};">{{ $banner->button_text }}</a>
                        @endif
                    </div>
                </div>
            </div>

        @endforeach
        </div>
        

        <div class="row">
        @foreach(App\Banner::where('size', 'small')->where('location', $slug)->get() as $banner)
            
            @php
                $float = "";
                if($banner->position == "izquierda"){
                    $float = "left";
                }else{
                    $float = "right";
                }

            @endphp

            <div class="col-md-3">
                <div class="main-banner__card-img">
                    <img src="{{ asset('/images/banners/'.$banner->image) }}" alt="" style="width: 100%;">
                    <div class="title" style="text-align: {{ $float }} !important">
                        <h3 style="color: {{ $banner->title_color }}">{{ $banner->title }}</h3>
                        <p style="color: {{ $banner->text_color }}">{{ $banner->text }}</p>
                        @if($banner->link != "" || $banner->button_text != "")
                        <a href="{{ $banner->link }}" target="_blank" class="btn-general" style="color: {{ $banner->button_color }}; background-color: {{ $banner->button_text_color }};">{{ $banner->button_text }}</a>
                        @endif
                    </div>
                </div>
            </div>

        @endforeach
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
                dolarPrice: '{!! App\DolarPrice::first()->price !!}',
                page:1
            }
        },
        methods:{
            
            fetch(page = 1){

                this.page = page

                axios.post("{{ route('brands.products') }}", {page: page, slug: this.slug})
                .then(res => {
                    console.log(res.data)
                    if(res.data.success == true){
                        this.pages = Math.ceil(res.data.productsCount / 20)
                        this.products = res.data.products
                    }else{

                        alertify.error(res.data.msg)

                    }

                })
                .catch(err => {
                    alertify.error("Error en el servidor")
                    //console.log(err.response.data)
                })

            },

        },
        mounted(){
            this.fetch()
        }

    })

</script>

@endpush