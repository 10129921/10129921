<?php
session_start();  // Iniciar sesión para poder destruirla
session_unset();  // Elimina todas las variables de sesión
session_destroy();  // Destruye la sesión

// Redirigir al usuario al formulario de inicio o registro
header("Location: destileria.html");  // Puedes cambiar esto a 'registro.php' si prefieres
exit();
?>
