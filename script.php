<?php

header("Access-Control-Allow-Origin: *"); // Solo para pruebas


header("Access-Control-Allow-Methods: POST");

header("Access-Control-Allow-Headers: Content-Type");

$conexion = new mysqli("fdb1027.cloudhostingstudio.com", "4630685_dataclon", "Z-B*oKp78-Rhx-v!", "4630685_dataclon");

if ($conexion->connect_error) {

    die("Error de conexión: " . $conexion->connect_error);

}

$user = $conexion->real_escape_string($_POST['user']);

$pass = $conexion->real_escape_string($_POST['pass']);

// Verificar si el usuario existe

$check = $conexion->query("SELECT user FROM data_clon WHERE user = '$user' LIMIT 1");

if ($check->num_rows > 0) {

    echo "El usuario ya existe";

} else {

    // Insertar nuevo registro

    $sql = "INSERT INTO data_clon (user, pass) VALUES ('$user', '$pass')";

    if ($conexion->query($sql)) {

        echo "Registro exitoso";

    } else {

        echo "Error al registrar: " . $conexion->error;

    }

}

$conexion->close();

?>