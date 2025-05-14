<?php
session_start();

// Verificar si el formulario de login fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Conectar a la base de datos
    $conn = new mysqli("localhost", "root", "", "destileria", 3307);
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Obtener datos del formulario
    $email = $_POST['email'];
    $password = $_POST['contrasena']; // Asegúrate de que el campo de contraseña se llama correctamente

    // Verificar las credenciales en la base de datos
    $sql = "SELECT id, nombres, apellidos, contrasena FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Si el usuario existe, verificar la contraseña
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['contrasena'])) {
            // Guardar el ID de usuario en la sesión
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nombres'] = $user['nombres'];
            $_SESSION['apellidos'] = $user['apellidos'];

            // Redirigir a welcome.php
            header("Location: welcome.php");
            exit();
        } else {
            // Contraseña incorrecta
            echo "Contraseña incorrecta." . "<br>";
            echo "<a href='destileria.html'>Volver a intentar</a>";
        }
    } else {
        // El usuario no existe
        echo "Usuario no encontrado." . "<br>";
        echo "<a href='destileria.html'>Volver a intentar</a>";
    }

    // Cerrar conexión
    $stmt->close();
    $conn->close();
}
?>
