@extends('layouts.main')

@section('content')

    <div class="container bg">
        <div class="row">
            <div class="col-12">
                <a class="btn btn-primary btn-general btn-general--form" style="color: #fff;" href="{{ url()->previous() }}"><i class="fa fa-arrow-left"></i></a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h2 class="text-center">¿Cómo comprar?</h2>
                <p>DeiraStore te brinda la posibilidad de realizar tu compra como usuario registrado o usuario invitado.</p>
                <p><strong>1.1 Usuario Registrado:</strong> Ingresa a <a href="{{ url('/') }}">www.deirastore.cl<a> y regístrate con los datos solicitados. Navega por las categorías de interés y selecciona tu(s) producto(s) en el carro de compras. Finalmente, completa los campos solicitados para elegir tu forma de pago y el tipo de entrega de tu(s) producto(s).</p>
                <p>
                    <strong>1.2 Usuario Invitado:</strong> Ingresa a <a href="{{ url('/') }}">www.deirastore.cl</a> y sin necesidad de registrarte navega por las categorías de interés, selecciona tu(s) producto(s) y completa los campos solicitados para elegir tu forma de pago y el tipo de entrega de tu(s) producto(s).
                </p>

            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h2 class="text-center">¿Como ver el estado de mi despacho?</h2>
                <p>
                Si el tipo de entrega que seleccionaste es despacho a domicilio y necesitas saber la fecha de recepción entonces ingresa a <a href="https://www.urbano.com.sv/wp/rastreo/">https://www.urbano.com.sv/wp/rastreo/</a> e inserta el código de seguimiento previamente entregado por DeiraStore a través de correo electrónico. Este código permitirá ver el estado de tu entrega para poder programar de mejor manera la recepción de tu(s) producto(s)
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h2 class="text-center">¿Qué hacer si el producto que busco no está disponible?</h2>
                <p>
                Si el producto que buscas no está registrado en nuestra página o se encuentra fuera de stock escríbenos a contacto@deira-it.com para brindarte la ayuda necesaria
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h2 class="text-center">¿Cómo recuperar mi contraseña?</h2>
                <p>Si ya eres usuario registrado pero olvidaste tu contraseña debes dirigrite a la sección de Loggin y solicitar cambio de contraseña. Posteriormente un email será enviado a tu correo electrónico registrado para que hagas el cambio y la generación de tu nueva contraseña.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h2 class="text-center">¿Cómo hacer la devolución de un producto?</h2>
                <p>Para aplicar el cambio o devolución de un producto, primero debe contactarse a pagos.web@deira.cl para definir y coordinar el envío del producto en falla. Este debe ser enviado mediante algún servicio de transporte privado, o llevado personalmente por el cliente, a Av. Salvador 1771, comuna de Ñuñoa. En caso de que el envío se haga a través de un transportista privado, el monto contemplado para dicho servicio se reembolsará luego solo en el caso de que el cambio o la devolución aplique bajo las políticas vigentes</p>
            </div>
        </div>


    </div>

    @include('partials.footer')

@endsection