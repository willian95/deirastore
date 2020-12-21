@extends('layouts.admin')

@section('content')

    @include('partials.admin.navbar')

    <style>
        #cke_editor1{
            height: 500px;
        }

        .cke_inner{
            height: 500px;
        }

        .cke_wysiwyg_frame {
            height: 500px !important;
        }

        #cke_1_contents{
            height: 500px !important;
        }
    </style>

    <div class="container content__admin">
        <div class="row" style="margin-top: 120px;">
            <div class="col-12">
                <h3 class="text-center">Tabla de Características</h3>
            </div>
        </div>
        <div class="row">
            
            <div class="col-12">
                
                <textarea name="editor1" id="editor1" rows="20" style="height: 500px;">{!! $product->feature !!}</textarea>
                <button style="display:none" @click="store()" id="click"></button>

                <p class="text-center" id="feature-app">
                    <button class="btn btn-success" @click="update()">Actualizar</button>
                </p>

            </div>
        </div>
    </div>


@endsection

@push('scripts')
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace( 'editor1' );
        function normalClick(){
            $("#click").click();
        }
    </script>
    <script>
        const app = new Vue({
            el: '#feature-app',
            data() {
                return {
                    featureId:"",
                    features:[],
                    productId:"{{ $id }}",
                    feature:"",
                    description:"",
                    action:"create"
                }
            },
            methods: {

                update(){
                    this.text = CKEDITOR.instances.editor1.getData()
                    axios.post("{{ url('/admin/feature/update') }}", {"feature": this.text, "id": this.productId}).then(res => {

                        if(res.data.success == true){


                            alertify.success(res.data.msg)
                     
                        }else{
                            alertify.error(res.data.msg)
                        }

                    })

                }

            },
            mounted() {
               
            }

        })
    </script>

@endpush