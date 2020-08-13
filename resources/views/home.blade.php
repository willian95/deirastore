@extends('layouts.main')

@section('content')

    <div class="container bg">
        <!-- banner -->
        <div class="row">
            <div class="main-banner__content container">
            @foreach(App\Banner::where('size', 'large')->where('location', 'landing')->get() as $banner)

                @php
                    $float = "";
                    if($banner->position == "izquierda"){
                        $float = "left";
                    }else{
                        $float = "right";
                    }

                @endphp

          
          
                <div class="main-banner__item">
                    @if($banner->link != "")
                        <a href="{{ $banner->link }}" target="_blank">
                    @endif
                    <div class="main-banner__img">
                        <img src="{{ asset('/images/banners/'.$banner->image) }}" alt="" style="width: 100%;">
                    </div>                                      
                    <div class="title" style="text-align: {{ $float }}; {{ $float }} : 0;">
                        <h3 style="color: {{ $banner->title_color }}">{{ $banner->title }}</h3>
                        <p style="color: {{ $banner->text_color }}">{{ $banner->text }}</p>
                        
                    </div>
                    @if($banner->link != "")
                        </a>
                    @endif
                </div>
                        
                                          
            @endforeach
        </div> 
        </div>


        <div class="row">
        @foreach(App\Banner::where('size', 'medium')->where('location', 'landing')->get() as $banner)

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
                        @if($banner->title != "" || $banner->title != "null")
                        <h3 style="color: {{ $banner->title_color }}">{{ $banner->title }}</h3>
                        @endif
                        @if($banner->text != "" || $banner->text != "null")
                        <p style="color: {{ $banner->text_color }}">{{ $banner->text }}</p>
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
        @foreach(App\Banner::where('size', 'small')->where('location', 'landing')->get() as $banner)
            
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

        <!-- categorias -->
        <section>
            <div class="title__general fadeInUp wow animated">
                <p><strong>Categorías</strong> principales</p>
            </div>

            <div class="container">
                <div class="main-categorias__content">
                    @foreach($categories as $category)
                        
                            <div class="main-categorias__item">
                                <div class="main-categorias-txt">
                                
                                    <a href="{{ url('/category/'.$category->category->slug) }}"> 
                                        @if($category->category->image != null)
                                            <img src="{{ asset('/images/categories/'.$category->category->image) }}" alt="">
                                        @else
                                            <img src="{{ asset('/images/brands/default.png') }}" alt="">
                                        @endif
                                        <span>{{ $category->category->esp_name}}</span>
                                    </a>
                                    
                                </div>
                            </div>
                        
                    @endforeach
                </div>
            </div>
        </section>

        <!-- tinedas -->
        <section class="mejores-tiendas">
            <div class="title__general title__general__blue">
                <p><strong>Mejores </strong> Tiendas</p>
            </div>

            <div class="container">
                <div class="main-shop__grid">
                    @foreach($brands as $brand)
                        
                        <a href="{{ url('/brand/'.$brand->brand->slug) }}">
                            <div class="main-shop__item">
                                
                                @if($brand->brand->image != null)
                                    <img class="style-marcas"  src="{{ asset('/images/brands/'.$brand->brand->image) }}" alt="">
                                @else
                                    <img class="style-marcas"  src="{{ asset('/images/brands/default.png') }}" alt="">
                                @endif
                                
                                <p>{{ $brand->brand->name }}</p>
                                <div class="main-shop__card">
                                    @foreach(App\Product::where('brand_id', $brand->brand_id)->whereNotNull("picture")->where("picture", "<>", "")->orderBy('id', 'desc')->limit(3)->get() as $product)
                                        <div class="main-shop__card-item">
                                        <!--    <a href="{{ url('/product/'.$product->slug) }}"> -->
                                            <span> 
                                            
                                                    <img style="width: 100%;" src="{{ $product->picture }}" alt="">
                                               
                                            </span>
                                        </div>

                                    @endforeach

                                </div>
                              Ver tienda
                            </div><!---main-shop__item ---></a>
                        

                    @endforeach

                </div>
            </div>



            <!---xs-->
            <div class="container">
                <div class="main-shop__grid tiendas_content">
                    @foreach($brands as $brand)
                        
                        <a href="{{ url('/brand/'.$brand->brand->slug) }}">
                            <div class="main-shop__item">
                                
                                @if($brand->brand->image != null)
                                    <img class="style-marcas"  src="{{ asset('/images/brands/'.$brand->brand->image) }}" alt="">
                                @else
                                    <img class="style-marcas"  src="{{ asset('/images/brands/default.png') }}" alt="">
                                @endif
                                
                                <p>{{ $brand->brand->name }}</p>
                                <div class="main-shop__card">
                                    @foreach(App\Product::where('brand_id', $brand->brand_id)->whereNotNull("picture")->where("picture", "like", "https://deirastore")->orderBy('id', 'desc')->limit(3)->get() as $product)
                                        <div class="main-shop__card-item">
                                        <!--    <a href="{{ url('/product/'.$product->slug) }}"> -->
                                            <span> 
                                            
                                                    <img style="width: 100%;" src="{{ $product->picture }}" alt="">
                                               
                                            </span>
                                        </div>

                                    @endforeach

                                </div>
                              Ver tienda
                            </div><!---main-shop__item ---></a>
                        

                    @endforeach

                </div>
            </div>
        </section>
        <!-- producto destacado -->
        <section>
            <div class="title__general fadeInUp wow animated">
                <p><strong>Productos </strong>Destacados</p>
            </div>

            <div class="container">
                <div class="main-slider__content">
                    @foreach(App\HighlightedProduct::with('product', 'product.category', 'product.brand')->get() as $product)
           
                        <a href="{{ url('/product/'.$product->product->slug) }}">
                            <div class="main-slider__item">
                                <div class="content-slider">

                                    @if($product->product->is_external == false)
                                        <img src="{{ asset('/images/products/'.$product->product->picture) }}" alt="" style="width: 100%">
                                    @else
                                        <img src="{{ $product->product->picture }}" alt="" style="width: 100%">
                                    @endif
                                </div>
                                <div class="main-slider__text">
                                    <p class="title">{{ $product->product->name }}</p>
                                    @if($product->product->brand)
                                        <span class="title-brand">{{ $product->product->brand->name }}</span>
                                        <br>
                                    @endif

                                    @if($product->product->category)
                                        <span>{{ $product->product->category->name }}</span>
                                        <br>
                                    @endif
                                    @if($product->product->percentage_range_profit != 0 && $product->product->percentage_range_profit != null)
                                        <span class="price">$ {{ number_format(intval($product->product->price_range_profit * App\DolarPrice::first()->price) + 1, 0, ",", ".") }}</span>
                                    @else
                                        <span class="price">$ {{ number_format(intval($product->product->external_price * App\DolarPrice::first()->price) + 1, 0, ",", ".") }}</span>
                                    @endif

                                    
                                    
                                    <!--<p class="price-old">Normal <span>$</span></p>-->
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
        
    </div>

    @include('partials.footer')

@endsection