<?php
// Conectar a MySQL y seleccionar la base de datos
$conn = new mysqli("localhost", "root", "", "base2");

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Sentencia SQL para eliminar la tabla
$sql = "DROP TABLE registros";

if ($conn->query($sql) === TRUE) {
    echo "Tabla 'registros' eliminada correctamente.";
} else {
    echo "Error al eliminar la tabla: " . $conn->error;
}

// Cerrar conexión
$conn->close();
?>
