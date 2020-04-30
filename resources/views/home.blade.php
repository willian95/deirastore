@extends('layouts.main')

@section('content')

    @include('partials.navbar')

    <div class="container bg">
        <!-- banner -->
        <div class="row">

            @foreach(App\Banner::where('size', 'large')->where('location', 'landing')->get() as $banner)

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
                        <div class="main-banner__img">
                            <img src="{{ asset('/images/banners/'.$banner->image) }}" alt="" style="width: 100%;">
                            <div class="main-banner__content">
                                <div class="title" style="text-align: {{ $float }};">
                                    <h3 style="color: {{ $banner->title_color }}">{{ $banner->title }}</h3>
                                    <p style="color: {{ $banner->text_color }}">{{ $banner->text }}</p>
                                    <a href="{{ $banner->link }}" target="_blank" class="btn-general" style="color: {{ $banner->button_color }}; background-color: {{ $banner->button_text_color }};">{{ $banner->button_text }}</a>
                                </div>
                            </div>
                        </div>


                    <!--</div>-->
                </div>
            @endforeach

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
                <div class="main-banner__card-img">
                    <img src="{{ asset('/images/banners/'.$banner->image) }}" alt="" style="width: 100%;">
                    <div class="title" style="text-align: {{ $float }} !important">
                        <h3 style="color: {{ $banner->title_color }}">{{ $banner->title }}</h3>
                        <p style="color: {{ $banner->text_color }}">{{ $banner->text }}</p>
                        <a href="{{ $banner->link }}" target="_blank" class="btn-general" style="color: {{ $banner->button_color }}; background-color: {{ $banner->button_text_color }};">{{ $banner->button_text }}</a>
                    </div>
                </div>
            </div>

        @endforeach
        </div>

        <!-- categorias -->
        <section>
            <div class="title__general">
                <p><strong>Categorías</strong> principales</p>
            </div>

            <div class="container">
                <div class="main-categorias__content">
                    @foreach($categories as $category)
                        @if($category->image != null)
                            <div class="main-categorias__item">
                                <div class="main-categorias-txt">
                                    <a href="{{ url('/category/'.$category->slug) }}"> 
                                        <img src="{{ asset('/images/categories/'.$category->image) }}" alt="">
                                        <span>{{ $category->name}}</span>
                                    </a>
                                </div>
                            </div>
                        @endif
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
                        @if($brand->image != null)
                            <div class="main-shop__item">
                                
                                <img src="{{ asset('/images/brands/'.$brand->image) }}" alt="">
                                
                                <p>{{ $brand->name }}</p>
                                <div class="main-shop__card">
                                    @foreach(App\Product::where('brand_id', $brand->id)->orderBy('id', 'desc')->limit(3)->get() as $product)
                                        <div class="main-shop__card-item">
                                            <a href="{{ url('/product/'.$product->slug) }}"> 
                                                @if($product->is_external == false)
                                                    <img style="width: 100%;" src="{{ asset('/images/products/'.$product->picture) }}" alt="">
                                                @else
                                                    <img style="width: 100%;" src="{{ $product->picture }}" alt="">
                                                @endif
                                            </a>
                                        </div>

                                    @endforeach

                                </div>
                                <a href="{{ url('/brand/'.$brand->slug) }}">Ver tienda</a>
                            </div>
                        @endif

                    @endforeach

                </div>
            </div>
        </section>
        <!-- producto destacado -->
        <section>
            <div class="title__general">
                <p><strong>Productos </strong>Destacados</p>
            </div>

            <div class="container">
                <div class="main-slider__content">
                    @foreach(App\Product::with('category')->inRandomOrder()->take(20)->get() as $product)
                        <a href="{{ url('/product/'.$product->slug) }}">
                            <div class="main-slider__item">
                                <div class="content-slider">

                                    @if($product->is_external == false)
                                        <img src="{{ asset('/images/products/'.$product->picture) }}" alt="" style="width: 100%">
                                    @else
                                        <img src="{{ $product->picture }}" alt="" style="width: 100%">
                                    @endif
                                </div>
                                <div class="main-slider__text">
                                    <span>{{ $product->name }}</span>

                                    @if($product->category)
                                        <p class="title">{{ $product->category->name }}</p>
                                    @endif
                                    @if($product->external_price > 0)
                                        <span class="price">$ {{ number_format(intval($product->external_price * App\DolarPrice::first()->price), 0, ",", ".") }}</span>
                                    @else
                                     <span class="price">$ {{ number_format($product->price, 0, ",", ".") }}</span>
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