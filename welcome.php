<?php
// Inicia la sesión para verificar el acceso del usuario
session_start();

// Verifica si el usuario ha iniciado sesión. Si no es así, redirige al login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();  // Detiene la ejecución del script si no está autenticado
}

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "destileria", 3307);

// Verifica si la conexión es exitosa. Si no, muestra un error y termina el script
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Función para contar registros en una tabla específica de la base de datos
function contarRegistros($conn, $tabla) {
    try {
        // Ejecuta una consulta para contar los registros en la tabla indicada
        $resultado = $conn->query("SELECT COUNT(*) AS total FROM $tabla");
        if ($resultado) {
            // Si la consulta es exitosa, obtiene el número de registros
            $fila = $resultado->fetch_assoc();
            return $fila['total'];
        } else {
            // Si la consulta falla (por ejemplo, si la tabla no existe), retorna 0
            return 0;
        }
    } catch (Exception $e) {
        // Captura cualquier excepción y retorna 0 si hay error
        return 0;
    }
}

// Llamadas a la función contarRegistros para obtener el número de registros en cada tabla
$clientes = contarRegistros($conn, 'clientes');
$empleados = contarRegistros($conn, 'empleados');
$licores = contarRegistros($conn, 'licores');
$stock_licores = contarRegistros($conn, 'stock_licores');
$stock_mp = contarRegistros($conn, 'stock_materia_prima');
$pedidos = contarRegistros($conn, 'pedidos');
$facturas = contarRegistros($conn, 'facturas');

// Cierra la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Bienvenida</title>
    <style>
        body {
            font-family: Georgia, 'Times New Roman', Times, serif;
            margin: 0;
            display: flex;
            background-color:#ceebc9;
        }

        /* Barra lateral */
        .sidebar {
            width: 220px;
            background-color:rgb(169, 193, 165);
            color: black;
            height: 100vh;
            padding: 20px;
            box-sizing: border-box;
        }

        .sidebar h2 {
            font-size: 25px;
            margin-bottom: 20px;
        }

        /* estilo texto barra lateral izquierdo */
        .sidebar a {
            display: block;
            color: black;
            text-decoration: none;
            margin: 10px 0;
            padding: 8px;
            border-radius: 4px;
        }
        /* color de fondo de los modulos */
        .sidebar a:hover {
            background-color:rgb(90, 235, 145);
        }

        /* Área de contenido principal */
        .main-content {
            flex-grow: 1;
            padding: 20px;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
        }

        .header img {
            width: 60px;
            margin-right: 15px;
        }

        .header h1 {
            font-size: 24px;
        }

        /* Tarjetas de resumen */
        .dashboard {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
        }

        .card {
            background-color:rgb(101, 164, 132);
            padding: 20px;
            border-left: 6px solidrgb(0, 0, 0);
            border-radius: 20px;
            box-shadow: 0 2px 6px rgba(230, 29, 29, 0.1);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: scale(1.02);
        }

        .card a {
            text-decoration: none;
            color: #000;
            display: block;
        }

        .card h3 {
            margin: 0;
            font-size: 20px;
        }

        .card p {
            margin-top: 8px;
            font-size: 24px;
            font-weight: bold;
        }

        .logout {
            margin-top: 500px;
        }

    </style>
</head>
<body>

    <!-- Barra lateral izquierda -->
    <div class="sidebar">
        <h2>Módulos</h2>
        <a href="clientes.php">Clientes</a>
        <a href="empleados.php">Empleados</a>
        <a href="licores.php">Licores</a>
        <a href="stock_licores.php">Stock Licores</a>
        <a href="stock_mp.php">Stock Materia Prima</a>
        <a href="pedidos.php">Pedidos</a>
        <a href="facturas.php">Facturas</a>
        <div class="logout">
            <a href="logout.php">Cerrar Sesión</a>
        </div>
    </div>

    <!-- Área principal de contenido -->
    <div class="main-content">
        <!-- Encabezado con logo y título -->
        <div class="header">
            <img src="ima3.png" alt="Logo">
            <h1>Bienvenido a Destilería Artesanal Jaguar👋🏼</h1>
        </div>

        <!-- Cuadros de resumen con enlaces -->
        <div class="dashboard">
            <!-- Cada tarjeta contiene un enlace y muestra el número de registros de la base de datos -->
            <div class="card"><a href="clientes.php"><h3>Clientes</h3><p><?= $clientes ?></p></a></div>
            <div class="card"><a href="empleados.php"><h3>Empleados</h3><p><?= $empleados ?></p></a></div>
            <div class="card"><a href="licores.php"><h3>Licores</h3><p><?= $licores ?></p></a></div>
            <div class="card"><a href="stock_licores.php"><h3>Stock Licores</h3><p><?= $stock_licores ?></p></a></div>
            <div class="card"><a href="stock_mp.php"><h3>Stock Materia Prima</h3><p><?= $stock_mp ?></p></a></div>
            <div class="card"><a href="pedidos.php"><h3>Pedidos</h3><p><?= $pedidos ?></p></a></div>
            <div class="card"><a href="facturas.php"><h3>Facturas</h3><p><?= $facturas ?></p></a></div>
        </div>
    </div>

</body>
</html>
