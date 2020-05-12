@extends('layouts.main')

@section('content')

    @include('partials.admin.navbar')

    <div class="container content__admin">
        <div class="row">
            <div class="col">
                <h3 class="mb-5 ml-4">Dashboard</h3>
                <div class="dash-grid">
                    <div class="dash-grid__item">
                        <i class="fa fa-info-circle info"></i>
                        <span>Orders</span>
                        <div class="dash-grdi__content">
                            <i class="fa fa-user"></i>
                            <p>192</p>
                        </div>
                    </div>
                    <div class="dash-grid__item">
                        <i class="fa fa-info-circle info"></i>
                        <span>Orders <small>on-hold</small></span>
                        <div class="dash-grdi__content">
                            <i class="fa fa-info-circle"></i>
                            <p>192</p>
                        </div>
                    </div>
                    <div class="dash-grid__item">
                        <i class="fa fa-info-circle info"></i>
                        <span>Stock <small>Productos</small></span>
                        <div class="dash-grdi__content">
                            <i class="fa fa-user"></i>
                            <p>192</p>
                        </div>
                    </div>
                    <div class="dash-grid__item">
                        <i class="fa fa-info-circle info"></i>
                        <span>Out of tock <small>Productos</small></span>
                        <div class="dash-grdi__content">
                            <i class="fa fa-user"></i>
                            <p>192</p>
                        </div>
                    </div>
                </div>
            </div> 
        


        </div>
    </div>

@endsection