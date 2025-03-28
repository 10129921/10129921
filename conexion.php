<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php

$host="localhost";
$user="root";
$pass="1526";
$dbname="base2";

$conn = new mysqli($host,$user,$pass,$dbname);

if($conn -> connect_error) {
    die("Error en la conexion: " . $conn ->connect_error);
}

?>
</body>
</html>