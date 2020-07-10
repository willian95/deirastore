@extends('layouts.main')

@section('content')

    <div class="container bg" v-cloak>
       <!-- <div class="col-12">
            <a class="btn btn-primary btn-general btn-general--form" style="color: #fff;" href="{{ url()->previous() }}"><i class="fa fa-arrow-left"></i></a>
        </div>-->
        <div class="title__general fadeInUp wow animated pag-center">
            <p style="position: relative;"><strong>Mejores</strong> Tiendas</p>
        </div>

        <div class="row">
            @foreach(App\BestStore::with("brand")->get() as $brand)
                <div class="col-md-3 col-xs-12 ">
                    <div class="main-slider__item">
                        <a href="{{ url('/brand/'.$brand->brand->slug) }}">
                            <div class="content-slider brands-center">
                                @if($brand->brand->image != null)
                                    <img src="{{ url('/images/brands/'.$brand->brand->image) }}" alt="" style="width: 100%">
                                @else
                                    <img src="{{ url('/images/brands/default.png') }}" alt="" style="width: 100%">
                                @endif
                            </div>
                            <div class="main-slider__text">
                                <span>{{ $brand->brand->name }}</span>
                            </div>
                        </a>
                    </div>
                </div>
                
            @endforeach
        </div>
   
    </div>

    @include('partials.footer')

@endsection

@push('scripts')

<script>
        
    const app = new Vue({
        el: '#dev-app',
        data(){
            return{
                brands:[],
                pages:0,
                page:1
            }
        },
        methods:{
            
            fetch(page = 1){
            
                this.page = page

                axios.post("{{ route('brands.fetch') }}", {page: page})
                .then(res => {

                    if(res.data.success == true){
                        this.pages = Math.ceil(res.data.brandsCount / 10)
                        this.brands = res.data.brands
                    }else{

                        alertify.error(res.data.msg)

                    }

                })
                .catch(err => {
                    alertify.error("Error en el servidor")
                    //console.log(err.response.data)
                })

            },

        },
        mounted(){
            this.fetch()
        }

    })

</script>

@endpush