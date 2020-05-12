<p>¡No te vayas! :( ¡Recuerda que tienes productos en tu carro de compras!</p>
<a href="{{ url('/cart') }}">¿Quieres finalizar tu compra?</a>
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