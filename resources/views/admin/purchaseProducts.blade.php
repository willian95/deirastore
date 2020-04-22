@extends('layouts.main')

@section('content')
    @include('partials.admin.navbar')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-md-8 offset-md-2 col-12">

                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Buscar</label>
                            <input type="text" class="form-control" id="name" v-model="query" @keyup="search()">
                        </div>
                    </div>
                </div>

                <div class="card" v-for="product in products">
                    <div class="card-body">
                        <p class="text-center">
                            @{{ product.name }}
                        </p>
                        <p>
                            Cantidad: @{{ product.amount }}
                        </p>
                        <button class="btn btn-success" @click="goToPurchases(product.id)">añadir</button>
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
        </div>
    </div>

@endsection

@push('scripts')
    
<script>
        
    const app = new Vue({
        el: '#dev-app',
        data(){
            return{
                modalTitle:"Añadir cantidad",
                products:'',
                pages:0,
                query:""

            }
        },
        methods:{
            
            fetch(page = 1){
                   
                axios.post("{{ route('admin.products.fetch') }}", {page: page})
                .then(res => {
                
                    this.products = res.data.products
                    this.pages = Math.ceil(res.data.productsCount / 10)

                })
                .catch(err => {
                    console.log(err.response.data)
                })

            },
            goToPurchases(id){
                
                window.location.href = "{{ url('/admin/purchase/product') }}/"+id

            },
            search(){

                if(this.query.length > 0){
                    this.pages = 0;
                    axios.post("{{ route('admin.products.search') }}", {search: this.query})
                    .then(res => {
                        this.products = res.data.products
                    })
                    .catch(err => {
                        console.log(err.response.data)
                    })

                }else{
                    this.fetch()
                }

            },

        },
        mounted(){
            this.fetch()
        }

    })

</script>

@endpush