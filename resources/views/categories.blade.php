@extends('layouts.main')

@section('content')

    <div class="container bg" id="dev-categories">

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
                
                @foreach(Category::with('child')->orderBy('name')->get() as $categoy)

                    @if(count($category->child) == 0)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/category/'.$category->slug) }}">{{ $category->name }}</a>
                        </li>
                    @endif

                    @if(count($category->child) > 0)
                        <li class="nav-item dropdown mega-menu">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="{{ url('/category/'.$category->slug) }}" role="button" aria-haspopup="true" aria-expanded="false">{{ $category->name }}</a>
                            <div class="dropdown-menu" style="opacity: 1;">
                                <div class="grid-menu">
                                    <div class="grid-menu__item">
                                        <ul>
                                            @foreach($category->child as $child)
                                                <li>
                                                    <a class="dropdown-item" href="{{ url('/category/'.$child->slug) }}">{{ $child->name }}</a>
                                                </li> 
                                            @endforeach                        
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endif
                    

                @endforeach
                
                
            </ul>

            <!--<button @click="moreItems()" v-if="page < maxPages && loading == false" class="btn btn-primary btn-general btn-general--form" style="color: #fff; height: 60px; width: 120px;">cargar más</button>-->
          
        </div>




    </div>
    @include('partials.footer')

@endsection

@push('scripts')

    <script>
        const navbar = new Vue({
            el: '#dev-categories',
            data(){
                return{
                    categories:null,
                    page:1,
                    maxPages:0,
                    loading:false
                }
            },
            methods:{
                
                getItems(){
                   
                    this.loading = true
                    axios.get("{{ url('/categories/menu') }}"+"/"+this.page)
                    .then(res => {
                        //console.log(res)
                        this.loading = false
                        if(res.data.success == true){
                            if(this.categories == null){
                                this.categories = res.data.categories
                                
                            }else{
                                res.data.categories.forEach((data, index) => {
                                    this.categories.push(data)
                                })
                            }

                            //this.maxPages = Math.ceil(res.data.categoriesCount/25)

                        }else{

                            alertify.error(res.data.msg)

                        }

                    })
                    .catch(err => {
                        this.loading = false
                        alertify.error("Error en el servidor")
                        //console.log(err.response.data)
                    })
                },
                moreItems(){
                    this.page ++;
                    this.getItems()
                }

            },
            mounted(){
                
                this.getItems()

            }

        })
    </script>

@endpush