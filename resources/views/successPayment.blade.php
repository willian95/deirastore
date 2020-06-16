@extends('layouts.main')

@section('content')

<div class="container bg">
    <div class="row">
        <div class="col-lg-12  col-md-12 col-12">
            <div class="car">
                <div class="title__general fadeInUp wow animated title__general_exit">
                    <p>¡Pago <strong>exitoso!</strong></p>
                </div>
                <div class="text-center datos_fecha">
                    <p class="m-0">Fecha: 12-06-2020 - Hora: 2:00pm</p>
                    <p>Medio de pago: Factura</p>
                </div>

                <div class="grid__datos mt-5">
                    <div class="grid__datos__item">
                        <div class="title__general  fadeInUp wow animated font-size">
                            <p class="text-justify">Datos de <strong>usuario</strong></p>
                        </div>

                        <div class="grid">
                            <p> <strong>Nombre: </strong> Willian</p>
                            <p> <strong>Apellido:</strong> Rodríguez</p>
                            <p> <strong>RUT:</strong> 123123123</p>
                            <p> <strong>Región:</strong> Antofagasta</p>
                            <p> <strong>Comuna:</strong> San Juan</p>
                            <p> <strong>Calle:</strong> Ribereña #4</p>
                        </div>
                    </div>

                    <div class="grid__datos__item">
                        <div class="title__general  fadeInUp wow animated font-size ">
                            <p class="text-justify">Datos de <strong>empresa</strong></p>
                        </div>

                        <p> <strong>Razón social:</strong> Tecnomarket Express</p>
                        <p> <strong>RUT de empresa:</strong> 123123</p>
                        <p> <strong>Dirección:</strong> Antofagasta San Pedro</p>
                    </div>
                </div>

                <div class="info-success">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="table__title">#</th>
                                <th class="table__title">Producto</th>
                                <th class="table__title">Cantidad</th>
                                <th class="table__title">Precio</th>
                                <th class="table__title">Precio de envío</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>1</td>
                                <td>Impresora HP 3600</td>
                                <td>1</td>
                                <td>54600</td>
                                <td>2300</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Cables USB</td>
                                <td>4</td>
                                <td>12000</td>
                                <td>300</td>
                            </tr>

                        </tbody>
                    </table>

                </div>

                <div>
                    <div class="colunm">
                        <p class="mb-0"><strong>Total de productos:</strong> 66600</p>
                        <p><strong>Total de productos + envío:</strong> 69200</p>
                    </div>

                </div>

                <!-- Letra muy pequeña -->
                <div class="title__general fadeInUp wow animated title__general2 mt-5">
                    <p class="text-justify ml-4">Información <strong>adicional</strong></p>
                </div>
                <div id="accordion" class="info__sucess">
                
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <strong> Tiempos de entrega y despachos: <i class="fa fa-plus"></i></strong>
                                </button>
                            </h5>
                        </div>

                        <div id="collapseOne" class="collapse sho" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">

                                <ul>
                                    <li>Para los despachos a domicilio los tiempos estimados de entrega en Región Metropolitana son de 5 -10 hábiles y se despacharán vía la empresa transportista Urbano. Podrás recibir tu código de seguimiento una vez que el producto se haya despachado a la compañía de transporte.</li>
                                    <li>El despacho al domicilio del cliente tiene un valor el cual varía según región, ciudad, comuna, peso y volumen del producto. Si decides que el producto lo envíen a domicilio, se te sumará un cargo al momento de pagar y Deira Tecnologías de Información S.A a través de un proveedor de servicios de logística externo, el cual despacha tu pedido pagado a la puerta de tu casa.</li>
                                    <li>Para retirar los productos en nuestra tienda física ubicada en Av. Salvador 1771, comuna de Ñuñoa, los tiempos de entrega son a partir de los 4 días hábiles.</li>
                                    <li>Deira Tecnologías de Información S.A, considera que todas las compras de los distribuidores o clientes están afectas a la posibilidad de entregas parciales de acuerdo a la disponibilidad de los productos. Deira Tecnologías de Información S.A, hará el máximo esfuerzo para entregar los pedidos en el menor plazo posible y cumplir con los requerimientos de los clientes. Sin embargo, Deira Tecnologías de Información S.A, no garantiza la fecha de entrega de los productos, ya que esta depende de la disponibilidad real, de la respuesta de los fabricantes y de procesos logísticos de adquisición o importación. Por lo cual, se entienden que todos los plazos indicados en el sitio son tiempos sugeridos y no reporta ningún tipo de obligación comercial o legal el no cumplimiento de ellos.</li>
                                    <li>Si al momento de la entrega del delivery en la dirección indicada no hay personal disponible para la recepción del producto, el transportista se retirará del domicilio para volver en una segunda y definitiva ocasión. Posterior a la segunda visita sin éxito el transportista devolverá el producto a las bodegas de Deira Tecnologías de Información S.A, donde el cliente deberá retirarlas personalmente o coordinar el segundo despacho con una nueva tarifa. No se permite la devolución del envío cancelado para el primer despacho fallido.</li>
                                    <li>¡Recuerda que tienes tu código de seguimiento!</li>
                                    <li>Deira Tecnologías de Información S.A, no acepta estar sometida a penalizaciones o multas de cualquier índole por incumplimiento en los plazos de entrega, errores de despacho o de productos. Esto debido a que hay procesos de facturación y logísticos que no están bajo el control Deira Tecnologías de Información S.A,. Considerando este punto, La compañía no pagará extras ni multas por atraso en los plazos de entrega o por errores en el despacho de productos.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <strong>Garantía <i class="fa fa-plus"></i></strong>
                                </button>
                            </h5>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body">

                                <p>
                                Deira Tecnologías de Información S.A garantiza el funcionamiento de todos los productos comercializados por el plazo indicado por el fabricante o marca del producto. Si el producto presenta alguna falla dentro de los primeros 10 (diez) días corridos contados desde la fecha de compra, éste podrá ser llevado directamente a Av. Salvador 1771, comuna de Ñuñoa, junto con la boleta o factura de compra.
                                </p>
                                <p>
                                Luego de ser ingresado el producto y haber recibido una orden de servicio, será evaluada y -eventualmente- comprobada la falla, podrá ser reemplazado por uno nuevo o reemplazado, decisión que tomará arbitrariamente Deira Tecnologías de Información S.A . En caso de ser necesario, Deira Tecnologías de Información S.A enviará el producto al servicio técnico autorizado de la marca actuando sólo como intermediario entre el cliente y el servicio técnico, el plazo de revisión, la aceptación o rechazo de la garantía será responsabilidad del servicio técnico autorizado. En caso de hacer efectiva la garantía y se realice la reparación o el reemplazo del producto por uno similar o nuevo, se mantendrá el plazo de garantía original a partir de la fecha de compra del equipo. En ningún otro caso se podrá extender o entender extendido el plazo de vigencia de la garantía.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingThree">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <strong>Términos y Condiciones sitio web Deira Store <i class="fa fa-plus"></i></strong>
                                </button>
                            </h5>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                            <div class="card-body">
                                <strong>Cambios y devoluciones.</strong>
                                <p>
                                De acuerdo a la normativa legal vigente, el cliente puede solicitar la devolución o cambio de un producto, siempre y cuando este presente fallas en su funcionamiento o existan errores en la descripción del producto. Es necesario aclarar que los cambios o devoluciones no aplican en el caso que el producto no sea del gusto del cliente o este no le haya sido compatible.
                                </p>
                                <p>
                                Para aplicar el cambio o devolución de un producto, primero debe contactarse a pagos.web@deira.cl para definir y coordinar el envío del producto en falla. Este debe ser enviado mediante algún servicio de transporte privado, o llevado personalmente por el cliente, a Av. Salvador 1771, comuna de Ñuñoa. En caso de que el envío se haga a través de un transportista privado, el monto contemplado para dicho servicio se reembolsará luego solo en el caso de que el cambio o la devolución aplique bajo las políticas vigentes. Adicionalmente, para aplicar el cambio se deben cumplir las siguientes condiciones:
                                </p>

                                <ol>
                                <li>El producto DEBE tener todos sus embalajes originales completos en la misma forma en las que fueron entregados, no pueden estar los sellos abiertos o roto.</li>
                                <li>El producto DEBE incluir todos sus accesorios sin uso</li>
                                <li>Para los productos devueltos por garantía, en primera instancia se le realizará un informe técnico, en el cual se validará que el producto no haya sido mal utilizado y que la falla es atribuible al producto, de ser así la garantía podrá aplicarse</li>
                                <li>En el caso de que el producto no presente la falla descrita por el cliente o en su defecto se compruebe que existió una mala manipulación de este, la garantía no aplicará y se podrán cargar al cliente los costos respectivos por revisión de servicio técnico, almacenaje y/o transporte. Estos costos serán informados previamente una vez recepcionado el producto</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingfour">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsefour" aria-expanded="false" aria-controls="collapsefour">
                                <strong>Marco Legal <i class="fa fa-plus"></i></strong>
                                </button>
                            </h5>
                        </div>
                        <div id="collapsefour" class="collapse" aria-labelledby="headingfour" data-parent="#accordion">
                            <div class="card-body">
                                <p>
                                Para conocer en detalle los derechos, visite el minisitio www.sernac.cl/aunclick/.En caso de tener problemas, los consumidores pueden acudir al SERNAC a través del sitio web www.sernac.cl, llamando gratis al 800 700 100 o también asistiendo en forma presencial a las oficinas de atención de público de SERNAC a lo largo del país
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingfive">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsefive" aria-expanded="false" aria-controls="collapsefive">
                                <strong>Contacto <i class="fa fa-plus"></i></strong>
                                </button>
                            </h5>
                        </div>
                        <div id="collapsefive" class="collapse" aria-labelledby="headingfive" data-parent="#accordion">
                            <div class="card-body">


                                <p>
                                Para la resolución de cualquier tipo de inconveniente o dudas, favor contáctese con contacto@deira-it.com o al número +562 2674 8000 y lo atenderemos ala brevedad posible.
                                </p>
                        
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <p class="text-center mt-5">
                <a class="btn-general2 " href="{{ url('/') }}" class="btn btn-success">Volver al inicio</a>
            </p>

        </div>
    </div>
</div>


@include('partials.footer')

@endsection

@push('scripts')
    
    <script>
        
        const app = new Vue({
            el: '#dev-app',
            data(){
                return{
                    user:""
                }
            },
            methods:{
                
                deleteStorage(){
                   window.localStorage.removeItem('cart')
                   window.localStorage.removeItem('checkoutProduct')
                }

            },
            mounted(){
               
                this.deleteStorage()
                this.user = JSON.parse(localStorage.getItem("guestUser"))

            }

        })
    
    </script>

@endpush