@extends('layouts.main')

@section('content')

    @include('partials.navbar')

    <div class="container">

        <div class="row">
            <div class="col-12">
                <h2 class="text-center">Productos</h2>
            </div>
        </div>

        <div class="row">
            @foreach($products as $product)

                <div class="col-3">
                    <div class="main-slider__item">
                        <a href="{{ url('/product/'.$product->slug) }}">
                            <div class="content-slider">
                                <img src="{{ asset('/images/products/'.$product->picture) }}" alt="">
                            </div>
                            <div class="main-slider__text">
                                <span>{{ $product->name }}</span>
                                <p class="title">{{ $product->category->name }}</p>
                                <span class="price">$ {{ $product->price }}</span>
                                <p class="price-old">Normal <span>$ {{ $product->sub_price }}</span></p>
                            </div>
                        </a>
                    </div>
                </div>

            @endforeach
        </div>

        <div class="row">
            <div class="col-12">
                <h2 class="text-center">Tiendas</h2>
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <h2 class="text-center">Categorias</h2>
            </div>
        </div>

    </div>

@endsection