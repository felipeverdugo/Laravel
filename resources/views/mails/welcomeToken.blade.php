<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Bienvenido a Vacunasist</title>
</head>
<body>
    <p>Hola{{ ' ' . $user->name .' '}} {{ $user->last_name .' ' }} </p>
    <p>El registro de usuario en el vacunatorio se completó con exito.</p>
    <p>Te enviamos el token para que inicies sesion.</p>
     <ul>
        <li>DNI: {{ $user->dni }}</li>
        <li>Token: {{ $user->user_token }}</li>
       
    </ul>
    <p>Utiliza tu DNI, la clave que ingresaste al registrarte y el token que te proporcionamos para iniciar sesion.</p>
<footer>
    Te saluda el staff de Vacunassist
</footer>
</body>