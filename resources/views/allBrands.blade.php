@extends('layouts.main')

@section('content')

    <div class="container bg">
       <!-- <div class="col-12">
            <a class="btn btn-primary btn-general btn-general--form" style="color: #fff;" href="{{ url()->previous() }}"><i class="fa fa-arrow-left"></i></a>
        </div>-->
        <div class="title__general fadeInUp wow animated pag-center">
            <p style="position: relative;"><strong>Todas las</strong> Marcas</p>

            <div class="row">
                <div class="col-12">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li>
                                <a class="page-link" v-if="page > 1" href="#" @click="fetch(page - 1)">Anterior</a>
                            </li>
                            <li class="page-item" v-for="index in pages">
                                <a class="page-link" href="#" v-if="index > page &&  index < page + 6"  :key="index" @click="fetch(index)" >@{{ index }}</a>
                            </li>
                            <li>
                                <a class="page-link" v-if="page < pages" href="#" @click="fetch(page + 6)">Siguiente</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

       
   


        <div class="row">
            <div class="col-md-3 col-xs-12 " v-for="brand in brands">
                <div class="main-slider__item">
                    <a :href="'{{ url('/') }}' + '/brand/' + brand.slug">
                        <div class="content-slider brands-center">
                            <img :src="'{{ url('/') }}' + '/images/brands/'+brand.image" alt="" v-if="brand.image != null" style="width: 100%">
                            <img :src="'{{ url('/') }}' + '/images/brands/default.png'" alt="" v-else style="width: 100%">
                        </div>
                        <div class="main-slider__text">
                            <span>@{{ brand.name }}</span>
                        </div>
                    </a>
                </div>
            </div>
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