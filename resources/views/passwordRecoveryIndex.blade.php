@extends('layouts.main')

@section('content')

    @include('partials.navbar')
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-md-6 offset-md-3 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" aria-describedby="emailHelp" v-model="email">
                        </div>
                    
                        <div class="form-group">
                            <button class="btn btn-primary" @click="recovery()">recuperar</button>
                        </div>

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
                    email:''
                }
            },
            methods:{
                
                recovery(){
                    
                    axios.post("{{ url('/password/recovery/send') }}", {email: this.email})
                    .then(res => {

                        if(res.data.success == true){
                            alert(res.data.msg)

                            window.location.href="{{ url('/') }}"

                        }else{

                            alert(res.data.msg)

                        }

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value){
                            alert(value)
                        });
                    })

                }

            },
            mounted(){
                //this.test()
            }

        })

    </script>

@endpush