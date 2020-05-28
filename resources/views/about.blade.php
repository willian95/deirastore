@extends('layouts.main')

@section('content')

    <div class="container bg">
  
        <div class="row">
            <div class="col-12">
                <a class="btn btn-primary btn-general btn-general--form" style="color: #fff;" href="{{ url()->previous() }}"><i class="fa fa-arrow-left"></i></a>
            </div>
        </div>


        <div class="about_content">
            <div class="title__general fadeInUp wow animated">
                <p><strong>Quines </strong>somos</p>
            </div>
            <div class="row">
                
                <div class="col-lg-6 col-xs-12">
                    <img src="https://images.unsplash.com/photo-1542744095-291d1f67b221?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=750&q=80" alt="">
                </div>
                <div class="col-lg-6 col-xs-12 about_text">
                    <p>Somos DeiraStore el ecommerce tecnológico más importante para las personas y las empresas de Chile.  Navega en nuestra plataforma y disfruta los más de 7000 productos de las marcas tecnológicas más grandes del mundo. </p>

                    <p>En DeiraStore encontrarás todo lo necesario para abastecer de tecnología tu oficina y tu espacio de trabajo en pocos clicks, de forma rápida y sencilla.  Disfrútalo!</p>
                </div>
            </div>
        </div>






     
        <div class="row">
            <div class="col-12">
             
            </div>
        </div>
    </div>

    @include('partials.footer')

@endsection