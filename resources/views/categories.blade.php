@extends('layouts.main')

@section('content')

        <div class="container bg">

        <div class="row">
            <div class="col-12">
                <a class="btn btn-primary btn-general btn-general--form" style="color: #fff;" href="{{ url()->previous() }}"><i class="fa fa-arrow-left"></i></a>
            </div>
        </div>
        <div class="title__general fadeInUp wow animated">
            <p><strong>Todas las </strong>Categorias</p>
        </div>
        <div class="">
           <ul class="categories__grid">
            <li class="nav-item dropdown mega-menu">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                    aria-haspopup="true" aria-expanded="false">Categorías</a>
                <div class="dropdown-menu" style="opacity: 1;">
                    <div class="grid-menu">
                        <div class="grid-menu__item">
                            <ul>
                                <li>Cables</li>
                                <li>Cámara y Escáners</li>
                                <li>Componentes de sistema</li>                            
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="">hola</a>
            </li>
            <li class="nav-item dropdown mega-menu">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                    aria-haspopup="true" aria-expanded="false">Categorías</a>
                <div class="dropdown-menu" style="opacity: 1;">
                    <div class="grid-menu">
                        <div class="grid-menu__item">
                            <ul>
                                <li>Cables</li>
                                <li>Cámara y Escáners</li>
                                <li>Componentes de sistema</li>                            
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="">hola 2</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="">hola 2</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="">hola 2</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="">hola 2</a>
            </li>
           </ul>
          
        </div>




    </div>
    @include('partials.footer')

@endsection