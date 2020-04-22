@extends('layouts.main')

@section('content')

    @include('partials.navbar')

    <div class="container">
        <div class="row">
            <div class="col-3" v-for="brand in brands">
                <div class="main-slider__item">
                    <a :href="'{{ url('/') }}' + '/brand/' + brand.slug">
                        <div class="content-slider">
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
        <div class="row">
            <div class="col-12">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item" v-for="index in pages">
                            <a class="page-link" href="#"  :key="index" @click="fetch(index)" >@{{ index }}</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>



@endsection

@push('scripts')

<script>
        
    const app = new Vue({
        el: '#dev-app',
        data(){
            return{
                brands:[],
                pages:0
            }
        },
        methods:{
            
            fetch(page = 1){

                axios.post("{{ route('brands.fetch') }}", {page: page})
                .then(res => {

                    if(res.data.success == true){
                        this.pages = Math.ceil(res.data.brandsCount / 10)
                        this.brands = res.data.brands
                    }else{

                        alert(res.data.msg)

                    }

                })
                .catch(err => {
                    console.log(err.response.data)
                })

            },

        },
        mounted(){
            this.fetch()
        }

    })

</script>

@endpush