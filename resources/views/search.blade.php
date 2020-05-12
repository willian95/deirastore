@extends('layouts.main')

@section('content')

    <div class="container bg">
        <div class="row">
            <div class="col-12">
                <a class="btn btn-primary btn-general btn-general--form" style="color: #fff;" href="{{ url()->previous() }}"><i class="fa fa-arrow-left"></i></a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="title__general title__general-start">
                    <p><strong>Resultado de:</strong> {{ $search }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach($products as $product)

                <div class="col-3">
                    <div class="main-slider__item">
                        <a href="{{ url('/product/'.$product->slug) }}">
                            <div class="content-slider">
                                @if($product->is_external == true)
                                    <img style="width: 100%;" src="{{ $product->picture }}" alt="">
                                @else
                                    <img style="width: 100%;" src="{{ asset('/images/products/'.$product->picture) }}" alt="">
                                @endif
                            </div>
                            <div class="main-slider__text">
                                <span>{{ $product->name }}</span>
                                <p class="title">{{ $product->category_name }}</p>
                                @if($product->external_price > 0)
                                    <span class="price">$ {{ number_format(intval($product->external_price * App\DolarPrice::first()->price), 0, ",", ".") }}</span>
                                @else
                                    <span class="price">$ {{ $product->price }}</span>
                                @endif
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
            @foreach($brands as $brand)

                <div class="col-3">
                    <div class="main-slider__item">
                        <a href="{{ url('/brand/'.$brand->slug) }}">
                            <div class="content-slider">
                                @if($brand->image != null)
                                    <img style="width: 100%;" src="{{ url('/images/brands/'.$brand->image) }}" alt="">
                                @else
                                    <img style="width: 100%;" src="{{ url('/images/brands/default.png') }}" alt="" >
                                @endif
                            </div>
                            <div class="main-slider__text">
                                <span>{{ $brand->name }}</span>
                            </div>
                        </a>
                    </div>
                </div>

            @endforeach
        </div>


        <div class="row">
            <div class="col-12">
                <h2 class="text-center">Categorias</h2>
            </div>
        </div>

        <div class="row">
            @foreach($categories as $category)

                <div class="col-3">
                    <div class="main-slider__item">
                        <a href="{{ url('/category/'.$category->slug) }}">
                            <div class="content-slider">
                                @if($category->image != null)
                                    <img style="width: 100%;" src="{{ url('/images/categories/'.$category->image) }}" alt="">
                                @else
                                    <img style="width: 100%;" src="{{ url('/images/categories/default.png ') }}" alt="" >
                                @endif
                            </div>
                            <div class="main-slider__text">
                                <span>{{ $category->name }}</span>
                            </div>
                        </a>
                    </div>
                </div>

            @endforeach
        </div>

    </div>

    @include('partials.footer')

@endsection