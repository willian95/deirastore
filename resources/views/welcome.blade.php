@extends('layouts.main')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <input class="form-control" v-model="email">
                    <input class="form-control" v-model="password">
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
                    email:'hla',
                    password:"hola"
                }
            },
            methods:{
                
                test(){
                    alert('hey')
                }

            },
            mounted(){
                //this.test()
            }

        })
    
    </script>

@endpush