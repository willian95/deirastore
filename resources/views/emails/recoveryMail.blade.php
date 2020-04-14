<h1>Recuperar contraseña</h1>



    <p>Hola {{ $user['name'] }}, sigue este enlace para cambiar tu clave <a href="{{ url('/password/recovery/restore/'.$user['recovery_hash']) }}">recuperar</a></p>


