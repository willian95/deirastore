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
                <h2 class="text-center">Quiénes 3 somos</h2>
            </div> 

        </div>
        <div class="row">
            <div class="col-12">
                <p>Somos DeiraStore el ecommerce tecnológico más importante para las personas y las empresas de Chile.  Navega en nuestra plataforma y disfruta los más de 7000 productos de las marcas tecnológicas más grandes del mundo. </p>

                <p>En DeiraStore encontrarás todo lo necesario para abastecer de tecnología tu oficina y tu espacio de trabajo en pocos clicks, de forma rápida y sencilla.  Disfrútalo!</p>
            </div>
        </div>
    </div>

    @include('partials.footer')

@endsection