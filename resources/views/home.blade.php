@extends('layouts.main')

@section('content')

@if(App\Modal::first()->status == "activado")
<!-- Modal -->
<div class="modal fade" id="modal-home" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
    
        <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          <div class="row">
                @if(App\Modal::first()->text != null && App\Modal::first()->image != null)
              <div class="col-md-6">
                  <p class="ml-4">{{ App\Modal::first()->text }}</p>
              </div>
              <div class="col-md-6">
                <img src="{{ App\Modal::first()->image }}" alt="" style="width: 100%;">
              </div>
              @elseif(App\Modal::first()->text != null && App\Modal::first()->image == null)
              <div class="col-md-12">
                  <p class="ml-4">{{ App\Modal::first()->text }}</p>
              </div>
              @elseif(App\Modal::first()->text == null && App\Modal::first()->image != null)
              <div class="col-md-12">
                <img src="{{ App\Modal::first()->image }}" alt="" style="width: 100%;">
              </div>
              @endif
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif

    <div class="container bg">
        <!-- banner -->
        <div class="row">
            <div class="main-banner__content container">
            @foreach(App\Banner::where('size', 'large')->where('location', 'landing')->orderBy("order")->get() as $banner)

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
        @foreach(App\Banner::where('size', 'medium')->where('location', 'landing')->orderBy("order")->get() as $banner)

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
        @foreach(App\Banner::where('size', 'small')->where('location', 'landing')->orderBy("order")->get() as $banner)
            
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
                            <div class="main-slider__item position-relative">
                            @if($product->product->amount == 0)
                                <span style="" class="stock">Sin stock</span>
                            @endif
                                <div class="content-slider">

                                    <img src="{{ $product->product->picture }}" alt="" style="width: 100%">
                                    
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
                                    @if($product->product->sale_price == null || $product->product->sale_price == 0)
                                    
                                        @if($product->product->percentage_range_profit > 0 && $product->product->percentage_range_profit != null)
                                            <span class="price">{{ number_format(intval($product->product->price_range_profit * App\DolarPrice::first()->price) + 1, 0, ",", ".") }}</span>
                                        @else
                                            <span class="price">{{ number_format(intval($product->product->external_price * App\DolarPrice::first()->price) + 1, 0, ",", ".") }}</span>
                                        @endif
                                    
                                    @else

                                        <span class="price" >$ {{ number_format(intval((App\DolarPrice::first()->price * $product->product->sale_price) + 1), 0,",", ".") }}</span>

                                        @if($product->product->percentage_range_profit > 0 && $product->product->percentage_range_profit != null)
                                            <strike class="price">
                                                <small style="font-size: 14px; color: red;">$ {{ number_format((intval(App\DolarPrice::first()->price * $product->product->price_range_profit) + 1), 0, ",", ".") }}</small>
                                            </strike>
                                        @else
                                            <strike class="price">
                                                <small style="font-size: 14px; color: red;">$ {{  number_format((intval(App\DolarPrice::first()->price * $product->product->external_price) + 1), 0, ",", ".") }}</small>
                                            </strike>
                                        @endif

                                    @endif
                                    {{--@if($product->product->percentage_range_profit != 0 && $product->product->percentage_range_profit != null)
                                        <span class="price">$ {{ number_format(intval($product->product->price_range_profit * App\DolarPrice::first()->price) + 1, 0, ",", ".") }}</span>
                                    @else
                                        <span class="price">$ {{ number_format(intval($product->product->external_price * App\DolarPrice::first()->price) + 1, 0, ",", ".") }}</span>
                                    @endif--}}

                                    
                                    
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

@push("scripts")

    @if(App\Modal::first()->status == "activado")
    <script>
        $(document).ready(function()
            {
            $("#modal-home").modal("show");
            });
    </script>
    @endif
  

@endpush