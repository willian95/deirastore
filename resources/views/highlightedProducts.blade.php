@extends('layouts.main')

@section('content')

    @include('partials.navbar')
    <div class="container bg">
        <div class="row">
            <div class="col-12">
                <a class="btn btn-primary btn-general btn-general--form" style="color: #fff;" href="{{ url()->previous() }}"><i class="fa fa-arrow-left"></i></a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="title__general title__general-start">
                    <p><strong>Productos destacados</strong></p>
                </div>
            </div>
        </div>

        <div class="row">
            
            @foreach(App\Product::with('category')->inRandomOrder()->where('amount', '>', 0)->take(20)->get() as $product)

        
                <div class="col-3">
                    <div class="main-slider__item">
                        <a href="{{ url('/product/'.$product->slug) }}">
                            <div class="content-slider">
                                @if($product->external == false)
                                    <img src="{{ $product->picture }}" alt="" style="width: 100%;">
                                @else
                                    <img src="{{ url('/images/products/'.$product->picture) }}" style="width: 100%;" alt="">
                                @endif
                            </div>
                            <div class="main-slider__text">
                                <span>{{ $product->name }}</span>
                                <p class="title">{{ $product->category->name }}</p>
                                @if($product->external_price > 0 && $product->price == 0)
                                    <span class="price">$ {{ number_format($product->external_price * App\DolarPrice::first()->price, 0, ",", ".") }}</span>
                                @else
                                    <span class="price">$ {{ number_format($product->price, 0, ",", ".") }}</span>
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