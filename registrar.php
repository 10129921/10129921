<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'] ?? ''; // Asegurar que la variable exista
    $identificacion = $_POST['identificacion'] ?? '';
    $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? ''; // Evitar error Undefined array key
    $email = $_POST['email'] ?? '';
    $contraseña = password_hash($_POST['Contraseña1'] ?? '', PASSWORD_DEFAULT); // Asegurar que siempre tenga un valor

    // Corregir el nombre de la columna en la base de datos
    $sql = "INSERT INTO registros (Nombre_Completo, identificacion, fecha_nacimiento, email, Contraseña1) 
            VALUES ('$nombre', '$identificacion', '$fecha_nacimiento', '$email', '$contraseña')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registro exitoso. Ahora puedes iniciar sesión.'); window.location.href='index.html';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "'); window.history.back();</script>";
    }

    $conn->close();
}
?>
