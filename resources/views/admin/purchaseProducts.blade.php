@extends('layouts.admin')

@section('content')
    @include('partials.admin.navbar')
    <div class="container content__admin">
        <div class="bsucador_admin col-md-8">
            <div class="card-body">
                <div class="form-group buscardor-admin">
                   <label for="" class="fa fa-search"></label>
                    <input  type="text" placeholder="Buscar producto..." class="form-control fa fa-search" id="name" v-model="query" @keyup="search()">
                </div>
            </div>
        </div>
        <div class="">

            <div class="grid_content">
                <div class="grid_content--item">
                 <div class="title mr-5">
                   Compras
                 </div>


                </div>
            
                <div class="grid_content--item ml-auto mr-4">
                    <div class="title">
                        <span class="page">Pagina:</span>
                        
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

            <div class="content_title">
                <div class="content_title__item">
                    <p>Nombre</p>
                </div>
                <div class="content_title__item ml-auto mr-12">
                    <p>Acciones</p>
                </div>
            </div>
            <div class="grid__product">

             

                <div class="card" v-for="product in products">
                    <div class="card-body">
                        <p >
                            @{{ product.name }}
                        </p>
                        <p>
                            Cantidad: @{{ product.amount }}
                        </p>
                        <button class="btn btn-success color-blue" @click="goToPurchases(product.id)">añadir</button>
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