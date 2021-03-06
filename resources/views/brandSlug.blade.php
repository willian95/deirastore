@extends('layouts.main')

@section('content')

    <div class="container bg" v-cloak>

    <div class="row">

                @foreach(App\Banner::where('size', 'large')->where('location', $slug)->where("vertical_position", "arriba")->orderBy("order")->get() as $banner)

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
                        @if($banner->link != "")
                            <a href="{{ $banner->link }}" target="_blank">
                        @endif
                            <div class="main-banner__card-img">
                                <img src="{{ asset('/images/banners/'.$banner->image) }}" alt="" style="width: 100%;">
                                <!--<div class="main-banner__content">-->
                                    <div class="title" style="text-align: {{ $float }};">
                                        <h3 style="color: {{ $banner->title_color }}">{{ $banner->title }}</h3>
                                        <p style="color: {{ $banner->text_color }}">{{ $banner->text }}</p>
                                    </div>
                                <!--</div>-->
                            </div>

                        @if($banner->link != "")
                            </a>
                        @endif
                        <!--</div>-->
                    </div>
                @endforeach

            </div>


            <div class="row">
                @foreach(App\Banner::where('size', 'medium')->where('location', $slug)->where("vertical_position", "arriba")->orderBy("order")->get() as $banner)

                    @php
                        $float = "";
                        if($banner->position == "izquierda"){
                            $float = "left";
                        }else{
                            $float = "right";
                        }

                    @endphp

                    <div class="col-md-6">
                        @if($banner->link != "")
                            <a href="{{ $banner->link }}" target="_blank">
                        @endif
                        <div class="main-banner__card-img">
                            <img src="{{ asset('/images/banners/'.$banner->image) }}" alt="" style="width: 100%;">
                            <div class="title" style="text-align: {{ $float }};">
                                <h3 style="color: {{ $banner->title_color }}">{{ $banner->title }}</h3>
                                <p style="color: {{ $banner->text_color }}">{{ $banner->text }}</p>
                                @if($banner->link != "" && $banner->button_text != "")
                                    <a href="{{ $banner->link }}" target="_blank" class="btn-general" style="color: {{ $banner->button_text_color }}; background-color: {{ $banner->button_color }};">{{ $banner->button_text }}</a>
                                @endif
                            </div>
                        </div>
                        @if($banner->link != "")
                            </a>
                        @endif
                    </div>

                @endforeach
            </div>
        

            <div class="row">
                @foreach(App\Banner::where('size', 'small')->where('location', $slug)->where("vertical_position", "arriba")->orderBy("order")->get() as $banner)
                    
                    @php
                        $float = "";
                        if($banner->position == "izquierda"){
                            $float = "left";
                        }else{
                            $float = "right";
                        }

                    @endphp

                    <div class="col-md-3">
                        @if($banner->link != "")
                            <a href="{{ $banner->link }}" target="_blank">
                        @endif
                        <div class="main-banner__card-img">
                            <img src="{{ asset('/images/banners/'.$banner->image) }}" alt="" style="width: 100%;">
                            <div class="title" style="text-align: {{ $float }} !important">
                                <h3 style="color: {{ $banner->title_color }}">{{ $banner->title }}</h3>
                                <p style="color: {{ $banner->text_color }}">{{ $banner->text }}</p>
                                @if($banner->link != "" || $banner->button_text != "")
                                <a href="{{ $banner->link }}" target="_blank" class="btn-general" style="color: {{ $banner->button_text_color }}; background-color: {{ $banner->button_color }};">{{ $banner->button_text }}</a>
                                @endif
                            </div>
                        </div>
                        @if($banner->link != "")
                            </a>
                        @endif
                    </div>

                @endforeach
            </div>

        <div class="title__general title__general-start fadeInUp wow animated pag-center">
            <p><strong>{{ $brand->name }}</strong></p>
            
            <div class="row">
                <div class="col-12">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="line-pag">
                                <a class="page-link" href="#" v-if="page > 1" @click="fetch(1)">Primero</a>
                            </li>
                            <li class="line-pag line-pag_r" >
                                <a class="page-link" v-if="page > 1" href="#" @click="fetch(page - 1)"><i class="fa fa-long-arrow-left" aria-hidden="true"></i>
                                </a>
                            </li>
                            <li class="page-item" v-for="index in pages">
                                <a class="page-link" style="background-color: #d32b2b; color: #fff !important;" href="#" v-if="page == index && index >= page - 3 &&  index < page + 3"  :key="index" @click="fetch(index)" >@{{ index }}</a>
                                <a class="page-link" href="#" v-if="page != index && index >= page - 3 &&  index < page + 3"  :key="index" @click="fetch(index)" >@{{ index }}</a> 
                            </li>
                            <li class="line-pag">
                                <a class="page-link" v-if="page < pages" href="#" @click="fetch(page + 1)"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                                </a>
                            </li>
                            <li class="line-pag">
                                <a class="page-link" href="#" v-if="page < pages" @click="fetch(pages)">último</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 col-lg-3">
                <div class="form-group">
                    <label for="">Ordernar por:</label>
                    <select class="form-control" v-model="filterOrder" @change="fetch()">
                        <option value="1">Nombre A - Z</option>
                        <option value="2">Nombre Z - A</option>
                        <option value="3">Precio Menor - Mayor</option>
                        <option value="4">Precio Mayor - Menor</option>
                        <option value="5">Stock Menor - Mayor</option>
                        <option value="6">Stock Mayor - Menor</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="form-group">
                    <label for="">Categorías:</label>
                    <select class="form-control" v-model="category" @change="fetch()">
                        <option value="0" >Todos</option>
                        <option :value="category.id" v-for="category in categories" v-if="category.esp_name" >@{{ category.esp_name }}</option>
                        <option :value="category.id" v-for="category in categories" v-else >@{{ category.name }}</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-xs-12 " v-for="product in products">
                <div class="main-slider__item position-relative" style="overflow: hidden;">
                    <a :href=" '{{ url('/') }}' + '/product/' + product.slug">
                        <span style="" class="stock" v-if="product.amount == 0">Sin stock</span>
                        <div class="content-slider">
                            <img :src="product.picture" style="width: 100%;" alt="">
                        </div>
                        <div class="main-slider__text">
                            <p class="title" >@{{ product.name }}</p>
                            <p class="title-brand">@{{ product.brand.name }}</p>
                            <span v-if="product.category">@{{ product.category.name }}</span>
                            
                            <div v-if="product.sale_price == null || product.sale_price == 0">
                                <span class="price" style="color: #d32b2b;" v-if="product.percentage_range_profit > 0 && product.percentage_range_profit != null"><strong>$ @{{ parseInt((dolarPrice * product.price_range_profit) + 1).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</strong></span>
                                <span class="price" style="color: #d32b2b;" v-else><strong>$ @{{  parseInt((dolarPrice * product.external_price) + 1).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</strong></span>
                            </div>
                            <div v-else>
                                <span class="price" style="color: #d32b2b;"><strong>$ @{{ parseInt((dolarPrice * product.sale_price) + 1).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</strong></span>
                                
                                <strike class="price" v-if="product.percentage_range_profit > 0 && product.percentage_range_profit != null"><small>$ @{{ parseInt((dolarPrice * product.price_range_profit) + 1).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</small></strike>
                                <strike class="price" v-else><small>$ @{{  parseInt((dolarPrice * product.external_price) + 1).toString().replace(/\B(?=(\d{3})+\b)/g, ".") }}</small></strike>

                            </div>
                            <!--<p v-if="product.sub_price > 0" class="price-old">Normal <span>$ @{{ product.sub_price }}</span></p>-->
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="line-pag">
                            <a class="page-link" href="#" v-if="page > 1" @click="fetch(1)">Primero</a>
                        </li>
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
                        <li class="line-pag">
                            <a class="page-link" href="#" v-if="page < pages" @click="fetch(pages)">último</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
     
        <div class="row">

            @foreach(App\Banner::where('size', 'large')->where('location', $slug)->where("vertical_position", "abajo")->orderBy("order")->get() as $banner)

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
                    @if($banner->link != "")
                        <a href="{{ $banner->link }}" target="_blank">
                    @endif
                        <div class="main-banner__card-img">
                            <img src="{{ asset('/images/banners/'.$banner->image) }}" alt="" style="width: 100%;">
                            <!--<div class="main-banner__content">-->
                                <div class="title" style="text-align: {{ $float }};">
                                    <h3 style="color: {{ $banner->title_color }}">{{ $banner->title }}</h3>
                                    <p style="color: {{ $banner->text_color }}">{{ $banner->text }}</p>
                                </div>
                            <!--</div>-->
                        </div>

                    @if($banner->link != "")
                        </a>
                    @endif
                    <!--</div>-->
                </div>
            @endforeach

        </div>


        <div class="row">
        @foreach(App\Banner::where('size', 'medium')->where('location', $slug)->where("vertical_position", "abajo")->orderBy("order")->get() as $banner)

            @php
                $float = "";
                if($banner->position == "izquierda"){
                    $float = "left";
                }else{
                    $float = "right";
                }

            @endphp

            <div class="col-md-6">
                @if($banner->link != "")
                    <a href="{{ $banner->link }}" target="_blank">
                @endif
                <div class="main-banner__card-img">
                    <img src="{{ asset('/images/banners/'.$banner->image) }}" alt="" style="width: 100%;">
                    <div class="title" style="text-align: {{ $float }};">
                        <h3 style="color: {{ $banner->title_color }}">{{ $banner->title }}</h3>
                        <p style="color: {{ $banner->text_color }}">{{ $banner->text }}</p>
                        @if($banner->link != "" && $banner->button_text != "")
                            <a href="{{ $banner->link }}" target="_blank" class="btn-general" style="color: {{ $banner->button_text_color }}; background-color: {{ $banner->button_color }};">{{ $banner->button_text }}</a>
                        @endif
                    </div>
                </div>
                @if($banner->link != "")
                    </a>
                @endif
            </div>

        @endforeach
        </div>
        

        <div class="row">
        @foreach(App\Banner::where('size', 'small')->where('location', $slug)->where("vertical_position", "abajo")->orderBy("order")->get() as $banner)
            
            @php
                $float = "";
                if($banner->position == "izquierda"){
                    $float = "left";
                }else{
                    $float = "right";
                }

            @endphp

            <div class="col-md-3">
                @if($banner->link != "")
                    <a href="{{ $banner->link }}" target="_blank">
                @endif
                <div class="main-banner__card-img">
                    <img src="{{ asset('/images/banners/'.$banner->image) }}" alt="" style="width: 100%;">
                    <div class="title" style="text-align: {{ $float }} !important">
                        <h3 style="color: {{ $banner->title_color }}">{{ $banner->title }}</h3>
                        <p style="color: {{ $banner->text_color }}">{{ $banner->text }}</p>
                        @if($banner->link != "" || $banner->button_text != "")
                        <a href="{{ $banner->link }}" target="_blank" class="btn-general" style="color: {{ $banner->button_text_color }}; background-color: {{ $banner->button_color }};">{{ $banner->button_text }}</a>
                        @endif
                    </div>
                </div>
                @if($banner->link != "")
                    </a>
                @endif
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
                page:1,
                filterOrder:"6",
                categories:[],
                category:"0"
            }
        },
        methods:{
            
            fetch(page = 1){

                this.page = page

                axios.post("{{ route('brands.products') }}", {page: page, slug: this.slug, filterOrder: this.filterOrder, category: this.category})
                .then(res => {
                  
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
            fetchCategories(){

                axios.post("{{ url('/brands/categories') }}", {slug: this.slug}).then(res => {

                    this.categories = res.data.categories

                })

            }

        },
        mounted(){
            this.fetch()
            this.fetchCategories()
        }

    })

</script>

@endpush