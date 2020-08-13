<table>

    <tbody>
    @foreach($sales as $sale)
        <tr>
            <th style="width: 10px; font-weight: bold;">Fecha</th>
            <th style="width: 30px; font-weight: bold;">Nombre</th>
            <th style="width: 30px; font-weight: bold;">Apellido</th>
            <th style="width: 20px; font-weight: bold;">Tipo de usuario</th>
            <th style="width: 20px; font-weight: bold;">Tipo de Facturación</th>
            <th style="width: 20px; font-weight: bold;">RUT</th>
            <th style="width: 30px; font-weight: bold;">Email</th>
            <th style="width: 20px; font-weight: bold;">Celular</th>
            <th style="width: 30px; font-weight: bold;">Región</th>
            <th style="width: 30px; font-weight: bold;">Comuna</th>
            <th style="width: 20px; font-weight: bold;">Calle</th>
            <th style="width: 10px; font-weight: bold;">Número</th>
            <th style="width: 10px; font-weight: bold;">Dept/Casa/Oficina</th>
            <th style="width: 30px; font-weight: bold;">Razón Social Empresa</th>
            <th style="width: 20px; font-weight: bold;">Rut Empresa</th>
            <th style="width: 30px; font-weight: bold;">Dirección Empresa</th>
            <th style="width: 20px; font-weight: bold;">Teléfono Empresa</th>
            <th style="width: 20px; font-weight: bold;">Correo empresa</th>
        </tr>
        <tr>
            <td>{{ $sale->created_at->format('d/m/y') }}</td>
            @if($sale->user)
                <td>{{ $sale->user->name }}</td>
                <td>{{ $sale->user->lastname }}</td>
                <td>Registrado</td>
                <td>{{ $sale->ticket_type }}</td>
                <td>{{ $sale->user->rut }}</td>
                <td>{{ $sale->user->email }}</td>
                <td>{{ $sale->user->phone_number }}</td>
                @if($sale->user->location)
                    <td>{{ $sale->user->location->name }}</td>
                    <td>{{ $sale->user->commune->name }}</td>
                @else
                    <td></td>
                    <td></td>
                @endif
                <td>{{ $sale->user->street }}</td>
                <td>{{ $sale->user->number }}</td>
                <td>{{ $sale->user->house }}</td>
                <td>{{ $sale->user->business_name }}</td>
                <td>{{ $sale->user->business_rut }}</td>
                <td>{{ $sale->user->business_address }}</td>
                <td>{{ $sale->user->business_phone }}</td>
                <td>{{ $sale->user->business_mail }}</td>
     
            @elseif($sale->guest)
                <td>{{ $sale->guest->name }}</td>
                <td>{{ $sale->guest->lastname }}</td>
                <td>Invitado</td>
                <td>{{ $sale->ticket_type }}</td>
                <td>{{ $sale->guest->rut }}</td>
                <td>{{ $sale->guest->email }}</td>
                <td>{{ $sale->guest->phone_number }}</td>
                @if($sale->guest->location)
                    <td>{{ $sale->guest->location->name }}</td>
                    <td>{{ $sale->guest->commune->name }}</td>
                @else
                    <td></td>
                    <td></td>
                @endif

                <td>{{ $sale->guest->street }}</td>
                <td>{{ $sale->guest->number }}</td>
                <td>{{ $sale->guest->house }}</td>
            @endif
        </tr>

        <!--<tr>
            <td colspan="18" style="font-weight: bold; text-align:center;">
                Compras
            </td>
        </tr>-->

        <tr>
            <td></td>
            <td style="font-weight: bold;">Articulo</td>
            <td style="font-weight: bold;">Cantidad</td>
            <td style="font-weight: bold;">Precio</td>
            <td style="font-weight: bold;">Tipo de envío</td>
            <td style="font-weight: bold;">Costo de envío</td>
            <td style="font-weight: bold;">Total</td>
            <td colspan="11"></td>
        </tr>

        @foreach($sale->productPurchase as $product)
            <tr>
                <td></td>
                <td>{{ $product->product->name }}</td>
                <td>{{ $product->amount }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->shipping_method }}</td>
                <td>{{ $product->shipping_cost }}</td>
                <td>{{ ($product->price * $product->amount) + $product->shipping_cost }}</td>
                <td colspan="11"></td>
            </tr>
        @endforeach

        <tr>
        <td colspan="18"></td>
        </tr>
        <tr>
        <td colspan="18"></td>
        </tr>

    @endforeach
    </tbody>
</table>