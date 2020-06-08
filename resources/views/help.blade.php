@extends('layouts.main')

@section('content')

    <div class="container bg">
        <div class="row">
         <!--   <div class="col-12">
                <a class="btn btn-primary btn-general btn-general--form" style="color: #fff;" href="{{ url()->previous() }}"><i class="fa fa-arrow-left"></i></a>
            </div>--->
        </div>





        <div class="title__general fadeInUp wow animated">
            <p><strong>  ¿Con qué podemos </strong>ayudarte? </p>
        </div>

      
        <div class="container demo">
	
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <i class="more-less fa fa-plus"></i>
                                <h4 class="mt-1"><i class="fa fa-question fa-icon"></i>   ¿Cómo comprar?</h4>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collaps" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            <p>DeiraStore te brinda la posibilidad de realizar tu compra como usuario registrado o usuario invitado.</p>
                            <p><strong>1.1 Usuario Registrado:</strong> Ingresa a <a href="{{ url('/') }}">www.deirastore.cl</a> y regístrate con los datos solicitados. Navega por las categorías de interés y selecciona tu(s) producto(s) en el carro de compras. Finalmente, completa los campos solicitados para elegir tu forma de pago y el tipo de entrega de tu(s) producto(s).</p>
                            <p>
                                <strong>1.2 Usuario Invitado:</strong> Ingresa a <a href="{{ url('/') }}">www.deirastore.cl</a> y sin necesidad de registrarte navega por las categorías de interés, selecciona tu(s) producto(s) y completa los campos solicitados para elegir tu forma de pago y el tipo de entrega de tu(s) producto(s).
                            </p>                        </div>
                    </div>
                </div>
        
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <i class="more-less fa fa-plus"></i>
                                <h4 class="mt-1"><i class="fa fa-info fa-icon"></i>  ¿Como ver el estado de mi despacho?</h4>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                            <p>
                                Si el tipo de entrega que seleccionaste es despacho a domicilio y necesitas saber la fecha de recepción entonces ingresa a <a href="https://www.urbano.com.sv/wp/rastreo/">https://www.urbano.com.sv/wp/rastreo/</a> e inserta el código de seguimiento previamente entregado por DeiraStore a través de correo electrónico. Este código permitirá ver el estado de tu entrega para poder programar de mejor manera la recepción de tu(s) producto(s)
                                </p>                        </div>
                    </div>
                </div>
        
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <i class="more-less fa fa-plus"></i>
                                <h4 class="mt-1" ><i class="fa fa-exclamation fa-icon"></i> ¿Qué hacer si el producto que busco no está disponible?</h4>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                        <div class="panel-body">
                            <p>
                                Si el producto que buscas no está registrado en nuestra página o se encuentra fuera de stock escríbenos a contacto@deira-it.com para brindarte la ayuda necesaria
                                </p>                        </div>
                    </div>
                </div>


                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingFour">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                <i class="more-less fa fa-plus"></i>
                                <h4 class="mt-1" ><i class="fa fa-unlock fa-icon"></i>¿Cómo recuperar mi contraseña?</h4>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                        <div class="panel-body">
                            <p>Si ya eres usuario registrado pero olvidaste tu contraseña debes dirigrite a la sección de Loggin y solicitar cambio de contraseña. Posteriormente un email será enviado a tu correo electrónico registrado para que hagas el cambio y la generación de tu nueva contraseña.</p>                      </div>
                    </div>
                </div>


                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingFive">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                <i class="more-less fa fa-plus"></i>
                                <h4 class="mt-1"><i class="fa fa-undo  fa-icon"></i>¿Cómo hacer la devolución de un producto?</h4>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
                        <div class="panel-body">
                            <p>Para aplicar el cambio o devolución de un producto, primero debe contactarse a pagos.web@deira.cl para definir y coordinar el envío del producto en falla. Este debe ser enviado mediante algún servicio de transporte privado, o llevado personalmente por el cliente, a Av. Salvador 1771, comuna de Ñuñoa. En caso de que el envío se haga a través de un transportista privado, el monto contemplado para dicho servicio se reembolsará luego solo en el caso de que el cambio o la devolución aplique bajo las políticas vigentes</p>                     </div>
                    </div>
                </div>
        
            </div><!-- panel-group -->
            
            
        </div><!-- container -->
     






    </div>


    


    @include('partials.footer')

@endsection