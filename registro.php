<?php
session_start();  // Iniciar sesión

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "destileria", 3307);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Comprobar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombres = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $identificacion = trim($_POST['identificacion']);
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['contrasena']), PASSWORD_DEFAULT); // Encriptar la contraseña
    $tipo_usuario = $_POST['tipo_usuario'];

    // Validación de campos vacíos
    if (empty($nombres) || empty($apellidos) || empty($identificacion) || empty($email) || empty($password) || empty($tipo_usuario)) {
        echo "<script>alert('⚠️ Todos los campos son obligatorios.');</script>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Validar formato de correo electrónico
        echo "<script>alert('⚠️ El correo electrónico no es válido.');</script>";
    } else {
        // Verificar si el correo ya está registrado
        $sql_email = "SELECT * FROM usuarios WHERE email = ?";
        if ($stmt = $conn->prepare($sql_email)) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $resultado_email = $stmt->get_result();

            if ($resultado_email->num_rows > 0) {
                echo "<script>alert('⚠️ El correo ya está registrado.');</script>";
            } else {
                // Verificar si la identificación ya está registrada
                $sql_identificacion = "SELECT * FROM usuarios WHERE identificacion = ?";
                if ($stmt_identificacion = $conn->prepare($sql_identificacion)) {
                    $stmt_identificacion->bind_param("s", $identificacion);
                    $stmt_identificacion->execute();
                    $resultado_identificacion = $stmt_identificacion->get_result();

                    if ($resultado_identificacion->num_rows > 0) {
                        echo "<script>alert('⚠️ La identificación ya está registrada.'); window.location.href='destileria.html';</script>";
                    } else {
                        // Insertar el nuevo usuario
                        $sql_insert = "INSERT INTO usuarios (nombres, apellidos, identificacion, email, contrasena, tipo_usuario) VALUES (?, ?, ?, ?, ?, ?)";
                        if ($stmt_insert = $conn->prepare($sql_insert)) {
                            $stmt_insert->bind_param("ssssss", $nombres, $apellidos, $identificacion, $email, $password, $tipo_usuario);
                            if ($stmt_insert->execute()) {
                                // Obtener el ID del usuario recién registrado
                                $user_id = $stmt_insert->insert_id;  // Este es el ID que se genera automáticamente al insertar un nuevo registro

                                // Guardar el ID del usuario en la sesión
                                $_SESSION['user_id'] = $user_id;

                                // Redirigir a destileria.html después de registrar al usuario
                                header("Location: destileria.html");
                                exit;  // Importante: Detener la ejecución del script para evitar problemas
                            } else {
                                echo "<script>alert('⚠️ Error al registrar el usuario: " . $stmt_insert->error . "');</script>";
                            }
                        } else {
                            echo "<script>alert('⚠️ Error al preparar la consulta de inserción.');</script>";
                        }
                    }
                    $stmt_identificacion->close();
                } else {
                    echo "<script>alert('⚠️ Error al preparar la consulta de validación de identificación.');</script>";
                }
            }
            $stmt->close();
        } else {
            echo "<script>alert('⚠️ Error al preparar la consulta de validación del correo.');</script>";
        }
    }
}

// Cerrar la conexión
$conn->close();
?>
