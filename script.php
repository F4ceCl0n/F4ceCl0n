<?php
// Permite CORS y métodos POST
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: text/plain');

// SOLO PARA DEBUG - Eliminar en producción
error_log(print_r($_REQUEST, true));

// Si es una preflight OPTIONS, termina aquí
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

// Conexión a MySQL (usa tus credenciales reales)
$servername = "fdb1027.cloudhostingstudio.com";
$username = "4630685_dataclon";
$password = "Z-B*oKp78-Rhx-v!";
$dbname = "4630685_dataclon";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        throw new Exception("Error de conexión: " . $conn->connect_error);
    }

    // Obtiene datos de POST o GET (según configuración del servidor)
    $data = $_SERVER['REQUEST_METHOD'] == 'POST' ? $_POST : $_GET;
    $user = $conn->real_escape_string($data['user'] ?? '');
    $pass = $conn->real_escape_string($data['pass'] ?? '');

    if (empty($user) || empty($pass)) {
        throw new Exception("Usuario y contraseña requeridos");
    }

    // Verifica si el usuario existe
    $check = $conn->query("SELECT user FROM data_clon WHERE user = '$user' LIMIT 1");
    
    if ($check->num_rows > 0) {
        echo "El usuario ya existe";
    } else {
        // Inserta nuevo registro
        $sql = "INSERT INTO data_clon (user, pass) VALUES ('$user', '$pass')";
        if ($conn->query($sql)) {
            echo "Registro exitoso";
        } else {
            throw new Exception("Error al registrar: " . $conn->error);
        }
    }
    
    $conn->close();
} catch (Exception $e) {
    http_response_code(500);
    echo "Error: " . $e->getMessage();
}
?>
