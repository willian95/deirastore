@extends('layouts.main')

@section('content')

    <div class="container bg">
        <div class="row">
          <!--  <div class="col-12">
                <a class="btn btn-primary btn-general btn-general--form" style="color: #fff;" href="{{ url()->previous() }}"><i class="fa fa-arrow-left"></i></a>
            </div>-->
        </div>

        <div class="row">
            <div class="col-12">
                <div class="title__general title__general-start fadeInUp wow animated">
                    <p><strong>Productos destacados</strong></p>
                </div>
            </div>
        </div>

        <div class="row">
            
            @foreach(App\HighlightedProduct::with('product', 'product.category', 'product.brand')->get() as $product)

        
                <div class="col-md-3 col-xs-12 ">
                    <div class="main-slider__item">
                        <a href="{{ url('/product/'.$product->product->slug) }}">
                            <div class="content-slider">
                                @if($product->product->external == false)
                                    <img src="{{ $product->product->picture }}" alt="" style="width: 100%;">
                                @else
                                    <img src="{{ url('/images/products/'.$product->product->picture) }}" style="width: 100%;" alt="">
                                @endif
                            </div>
                            <div class="main-slider__text">
                                <p class="title">{{ $product->product->name }}</p>
                                <span class="title-brand">{{ $product->product->name }}</span>
                                @if($product->product->category)
                                <span >{{ $product->product->category->name }}</span>
                                @endif
                                @if($product->product->external_price > 0 && $product->product->price == 0)
                                    <span class="price">$ {{ number_format( intval($product->product->external_price * App\DolarPrice::first()->price) + 1, 0, ",", ".") }}</span>
                                @else
                                    <span class="price">$ {{ number_format($product->product->price, 0, ",", ".") }}</span>
                                @endif
                            </div>
                        </a>
                    </div>
                </div>
            
            @endforeach
        </div>
    </div>

    @include('partials.footer')

@endsection