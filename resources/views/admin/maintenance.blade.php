@extends('layouts.admin')

@section('content')

    @include('partials.admin.navbar')

    <div class="container content__admin">
        <div class="row">
            <div class="col-12">

                <p class="text-center">
                    <button class="btn btn-danger" @click="activate()" v-if="maintenance == false">Activar mantenimiento</button>
                    <button class="btn btn-success" @click="deactivate()" v-else>Desactivar mantenimiento</button>
                </p>

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
                   maintenance:false
                }
            },
            methods:{
                
                check(){

                    axios.get("{{ url('/admin/maintenance/check') }}")
                    .then(res => {

                        this.maintenance == res.data.success

                    })

                },
                activate(){

                    axios.post("{{ url('admin/maintenance/activate') }}")
                    .then(res => {
                        
                        if(res.data.success == true){
                            alert(res.data.msg)
                            this.check()
                        }else{
                            alert(res.data.msg)
                        }

                    })

                },
                deactivate(){

                    axios.post("{{ url('admin/maintenance/deactivate') }}")
                    .then(res => {
                        
                        if(res.data.success == true){
                            alert(res.data.msg)
                            this.check()
                        }else{
                            alert(res.data.msg)
                        }

                    })

                }


            },
            mounted(){
                this.check()
            }

        })
    
    </script>

@endpush