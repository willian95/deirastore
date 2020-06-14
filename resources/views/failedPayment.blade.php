@extends('layouts.main')

@section('content')
    <div class="container bg">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-md-6 offset-md-3 col-12">

                <div class="car">
                    <div class="title__general fadeInUp wow animated ">
                        <p>¡Pago <strong>fallido!</strong></p>
                      </div>
                   
                </div>
            </div>

         
        </div>
        <p class="text-center mt-5">
            <a class="btn-general2 " href="{{ url('/') }}" class="btn btn-success">Volver al inicio</a>
          </p>
    </div>

    @include('partials.footer')

@endsection