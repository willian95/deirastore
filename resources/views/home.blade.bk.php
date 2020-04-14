@extends('layouts.main')

@section("content")
    @include('partials.navbar')
    
    <div class="container">
        <div class="row">

            @foreach($products as $product)

                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">

                            <img src="{{ url('/').'/images/products/'.$product->picture }}" style="width: 100%">
                            <h3 class="text-center">{{ $product->name }}</h3>
                            <p>{{ $product->price }}</p>
                            <a href="{{ url('/product/'.$product->slug) }}">ver</a>

                        </div>
                    </div>
                </div>

            @endforeach

        </div>
    </div>

@endsection