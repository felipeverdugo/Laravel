<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Bienvenido a Vacunasist</title>
</head>
<body>
    <p>Hola{{ ' ' . $aplicacion->paciente->name .' '}} {{ $aplicacion->paciente->last_name .' ' }} </p>
    <p>Tu vacuna para{{' ' . $aplicacion->vacuna->nombre . ' '}}ha sido aplicada.</p>
    
    
<footer>
    Te saluda el staff de Vacunassist
</footer>
</body>