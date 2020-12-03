@extends('layouts.main')

@section('content')

    <div class="container bg">

        <div class="row">
            <div class="col-12">
                <h3 class="text-center">Wishlist</h3>
            </div>

            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Producto</th>
                            <th>Stock</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(wish, index) in wishes">
                            <td>@{{ index + 1 }}</td>
                            <td>
                                <p>@{{ wish.product.name }}</p>
                                <img :src="wish.product.picture" alt="" style="width: 200px;">
                            </td>
                            <td>
                                @{{ wish.product.amount }}
                            </td>
                            <td>
                                <a class="btn btn-info" style="color: #fff;" :href="'{{ url('/product') }}'+'/'+wish.product.slug"><i class="fa fa-eye"></i></a>
                                <button class="btn btn-secondary" @click="removeFromWishlist(wish.product.id)"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        
        </div>

    </div>

@endsection

@push('scripts')

    <script>
        const app = new Vue({
            el: '#dev-app',
            data() {
                return {
                    wishes: []
                }
            },
            methods: {

                fetch(){

                    axios.get("{{ url('wishlist-fetch-products') }}").then(res => {

                        this.wishes = res.data.wishes

                    })

                },
                removeFromWishlist(id){

                    axios.post("{{ url('wishlist-remove') }}", {"productId": id}).then(res => {

                        if(res.data.success == true){

                            alertify.success(res.data.msg)
                            this.fetch()
                        }else{

                            alertify.error(res.data.msg)

                        }

                    })

                }

            },
            mounted() {
                this.fetch()
            }

        })
    </script>

@endpush