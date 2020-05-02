<h1>Ha realizado una compra</h1>

<p>Estimado(a) {{ $user['name'] }}, gracias por preferirnos, a continuación, podrás ver el resumen de tu compra. Tu compra aún no está confirmada, dentro de los próximos minutos te enviaremos un correo notificando esta confirmación, la fecha para el retiro de tus productos o el código de seguimiento para el tracking del delivery de tu compra </p>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio unitario</th>
            <th>Precio Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $product->product->name }}</td>
                <td>{{ $product->amount }}</td>
                <td>{{ $product->price / $product->amount }}</td>
                <td>{{ $product->price }}</td>
            </tr>

        @endforeach
    </tbody>
</table>


