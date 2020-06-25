@extends('layouts.admin')

@section('content')

    @include('partials.admin.navbar')

    <div class="container content__admin">

        <div class="row">
            <div class="col-12">
                <p class="text-center">
                    <button class="btn btn-success" @click="change('brands')">Marca</button>
                    <button class="btn btn-success" @click="change('categories')">Categorías</button>
                    <button class="btn btn-success" @click="change('products')">Producto</button>
                </p>
            </div>
            <div class="col-12">

                <div v-if="type == 'brands'">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Marca</label>
                                <select class="form-control" v-model="brand">
                                    <option v-for="brand in brands" :value="brand.id">@{{ brand.name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Porcentaje</label>
                                <input type="text" class="form-control" v-model="percentage">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button class="btn btn-success" @click="apply()" style="margin-top: 32px;">Aplicar</button>
                            </div>
                        </div>
                    </div>

                </div>

                <div v-if="type == 'categories'">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Categoría</label>
                                <select class="form-control" v-model="category">
                                    <option v-for="category in categories" :value="category.id">@{{ category.esp_name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Porcentaje</label>
                                <input type="text" class="form-control" v-model="percentage">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button class="btn btn-success" @click="apply()" style="margin-top: 32px;">Aplicar</button>
                            </div>
                        </div>
                    </div>

                </div>

                <div v-if="type == 'products'">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Producto</label>
                                <input type="text" class="form-control" v-model="searchString" @change="search()">
                            </div>

                            <ul class="list-group">
                                <li class="list-group-item" v-for="product in products" @click="selectProduct(product)" style="cursor: pointer">
                                    @{{ product.name }}
                                </li>
                            </ul>

                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Porcentaje</label>
                                <input type="text" class="form-control" v-model="percentage">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button class="btn btn-success" @click="apply()" style="margin-top: 32px;">Aplicar</button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-12">

                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Log</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(historyRangeProfit, index) in historyRangeProfits">
                            <td>@{{ index + 1 }}</td>
                            <td>@{{ historyRangeProfit.log }}</td>
                            <td>@{{ historyRangeProfit.created_at.toString().substring(0, 10) }}</td>
                        </tr>
                    </tbody>

                </table>

            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="line-pag">
                            <a class="page-link" href="#" v-if="page > 1" @click="fetch(1)">Primero</a>
                        </li>
                        <li class="line-pag line-pag_r" >
                            <a class="page-link" v-if="page > 1" href="#" @click="fetch(page - 1)"><i class="fa fa-long-arrow-left" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="page-item" v-for="index in pages">
                            <a class="page-link" style="background-color: #d32b2b; color: #fff !important;" href="#" v-if="page == index && index >= page - 3 &&  index < page + 3"  :key="index" @click="fetch(index)" >@{{ index }}</a>
                            <a class="page-link" href="#" v-if="page != index && index >= page - 3 &&  index < page + 3"  :key="index" @click="fetch(index)" >@{{ index }}</a> 
                        </li>
                        <li class="line-pag">
                            <a class="page-link" v-if="page < pages" href="#" @click="fetch(page + 6)"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="line-pag">
                            <a class="page-link" href="#" v-if="page < pages" @click="fetch(pages)">último</a>
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
                    brands:"",
                    categories:"",
                    products:"",
                    category:"",
                    brand:"",
                    searchString:"",
                    product:"",
                    percentage:"",
                    type:"",
                    historyRangeProfits:"",
                    pages:0,
                    page:1
                }
            },
            methods:{
                
                change(string){

                    this.type = string

                    if(string == "brands"){
                        this.fetchBrands()
                    }else if(string == 'categories'){
                        this.fetchCategories()
                    }

                },
                fetch(page = 1){

                    this.page = page

                    axios.get("{{ url('/admin/range-profit/fetch/') }}"+"/"+this.page).then(res => {

                        if(res.data.success == true){
                            this.pages = Math.ceil(res.data.historyRangeProfitCount / 20)
                            this.historyRangeProfits = res.data.historyRangeProfits
                        }

                    })

                },
                fetchBrands(){

                    axios.get("{{ url('/brands/fetch/all') }}").then(res => {

                        if(res.data.success == true){
                            this.brands = res.data.brands
                        }

                    })

                },
                fetchCategories(){

                    axios.get("{{ url('/categories/all') }}").then(res => {

                        if(res.data.success == true){
                            this.categories = res.data.categories
                        }

                    })

                },
                selectProduct(product){

                    this.product = product.id
                    this.searchString = product.name
                    alert("product seleccionado")
                    this.products = ""

                },
                search(){

                    axios.post("{{ url('/admin/highlighted-product/search') }}", {search: this.searchString})
                    .then(res => {

                        if(res.data.success == true){
                            this.products = res.data.products
                        }else{
                            alert(res.data.msg)
                        }

                    })

                },
                apply(){

                    axios.post("{{ url('admin/range-profit/apply') }}", {brand_id: this.brand, category_id: this.category, type: this.type, percentage: this.percentage, product_id: this.product})
                    .then(res => {

                        if(res.data.success == true){
                            alert(res.data.msg)
                            this.type = ""
                            this.brand = ""
                            this.product = ""
                            this.percentage = ""
                            this.fetch()
                        }else{
                            alert(res.data.msg)
                        }

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value) {
                            alertify.error(value);
                            //alertify.alert('Basic: true').set('basic', true); 
                        });
                    })

                }

            },
            mounted(){
                this.fetch()
            }

        })
    
    </script>

@endpush