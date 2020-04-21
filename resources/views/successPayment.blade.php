@extends('layouts.main')

@section('content')
    @include('partials.navbar')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-md-8 offset-md-2 col-12">
                <div class="card">
                    <h2>Pago exitoso</h2>

                    <p>Nombre: {{ \Auth::user()->name }}</p>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                   <td>{{ $loop->index + 1 }}</td>
                                   <td>{{ $product->product->name }}</td>
                                   <td>{{ $product->amount }}</td> 
                                   <td>{{ $product->price }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <p class="text-center">
                        <a href="{{ url('/') }}" class="btn btn-success">Volver al inicio</a>
                    </p>

                </div>
            </div>
        </div>
    </div>
@endsection