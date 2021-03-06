@extends('layouts.main')

@section('content')

<div class="container bg" id="dev-categories">

    <div class="row" v-cloak>
        <!--- <div class="col-12">
                <a class="btn btn-primary btn-general btn-general--form" style="color: #fff;" href="{{ url()->previous() }}"><i class="fa fa-arrow-left"></i></a>
            </div>--->
    </div>
    <div class="title__general fadeInUp wow animated">
        <p><strong>Todas las </strong>Categorias</p>
    </div>


    <div class="" v-cloak>
        <ul class="categories__grid">
            <div v-for="category in categories">

                <li class="nav-item dropdown-toggle" v-if="category.child.length == 0 && category.parent_id == null">
                    <a class="nav-link" :href='"{{ url("/category/") }}"+"/"+category.slug' v-if="category.esp_name">@{{ category.esp_name  }}</a>
                    <!--<a class="nav-link" :href='"{{ url("/category/") }}"+"/"+category.slug' v-else="category.name">@{{ category.name  }}</a>-->
                </li>

                <li class="nav-item dropdown mega-menu" v-if="category.child.length > 0">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">@{{ category.esp_name }}</a>
                    <div class="dropdown-menu" style="opacity: 1;">
                        <div class="grid-menu">
                            <div class="grid-menu__item">
                                <ul v-if="category.child.length > 0">
                                    <li v-for="child in category.child">
                                        <a class="dropdown-item" :href='"{{ url("/category/") }}"+"/"+child.slug'>@{{ child.esp_name }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

            </div>

        </ul>

        <button @click="moreItems()" v-if="page < maxPages && loading == false" class="btn btn-primary btn-general btn-general--form" style="color: #fff; height: 60px; width: 120px;">cargar más</button>

    </div>




</div>
@include('partials.footer')

@endsection

@push('scripts')

<script>
    const navbar = new Vue({
        el: '#dev-categories',
        data() {
            return {
                categories: null,
                page: 1,
                maxPages: 0,
                loading: false
            }
        },
        methods: {

            getItems() {

                this.loading = true
                axios.get("{{ url('/categories/menu') }}" + "/" + this.page)
                    .then(res => {
                        //console.log(res)
                        this.loading = false
                        if (res.data.success == true) {
                            if (this.categories == null) {
                                this.categories = res.data.categories

                            } else {
                                res.data.categories.forEach((data, index) => {
                                    this.categories.push(data)
                                })
                            }

                            this.maxPages = Math.ceil(res.data.categoriesCount / 25)

                        } else {

                            alertify.error(res.data.msg)

                        }

                    })
                    .catch(err => {
                        this.loading = false
                        alertify.error("Error en el servidor")
                        //console.log(err.response.data)
                    })
            },
            moreItems() {
                this.page++;
                this.getItems()
            }

        },
        mounted() {

            this.getItems()

        }

    })
</script>

@endpush