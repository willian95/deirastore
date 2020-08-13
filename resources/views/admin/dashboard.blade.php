@extends('layouts.admin')

@section('content')

    @include('partials.admin.navbar')

    <div class="container content__admin">
        <div class="row">
            <div class="col">
                <h3 class="mb-5 ml-4">Dashboard</h3>
                <div class="dash-grid">
                    <div class="dash-grid__item">
                        <i class="fa fa-info-circle info"></i>
                        <span>Productos Ingram con Stock</span>
                        <div class="dash-grdi__content">
                            <i class="fa fa-user"></i>
                            <p>{{ App\Product::where("data_source_id", 2)->where("amount", ">", 0)->count() }}</p>
                        </div>
                    </div>
                    <div class="dash-grid__item">
                        <i class="fa fa-info-circle info"></i>
                        <span>Productos Ingram sin Stock <!--<small>on-hold</small>--></span>
                        <div class="dash-grdi__content">
                            <i class="fa fa-info-circle"></i>
                            <p>{{ App\Product::where("data_source_id", 2)->where("amount", 0)->count() }}</p>
                        </div>
                    </div>
                    <div class="dash-grid__item">
                        <i class="fa fa-info-circle info"></i>
                        <span>Productos Nexsys con Stock</span>
                        <div class="dash-grdi__content">
                            <i class="fa fa-user"></i>
                            <p>{{ App\Product::where("data_source_id", 1)->where("amount", ">", 0)->count() }}</p>
                        </div>
                    </div>
                    <div class="dash-grid__item">
                        <i class="fa fa-info-circle info"></i>
                        <span>Productos Nexsys sin Stock</span>
                        <div class="dash-grdi__content">
                            <i class="fa fa-user"></i>
                            <p>{{ App\Product::where("data_source_id", 1)->where("amount", 0)->count() }}</p>
                        </div>
                    </div>
                </div>
            </div> 
        


        </div>
    </div>

@endsection