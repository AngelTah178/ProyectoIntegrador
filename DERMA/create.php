<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "historias_clinicas";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $edad = $_POST['edad'];
    $telefono = $_POST['telefono'];
    $genero = $_POST['genero'];
    $lugar_residencia = $_POST['lugar_residencia'];
    $ocupacion_actual = $_POST['ocupacion_actual'];
    $motivo_consulta = $_POST['motivo_consulta'];
    $fecha = $_POST['fecha'];
    $procedimiento = $_POST['procedimiento'];

    $sql = "INSERT INTO historias (nombre, edad, telefono, genero, lugar_residencia, ocupacion_actual, motivo_consulta, fecha, procedimiento)
            VALUES ('$nombre', '$edad', '$telefono', '$genero', '$lugar_residencia', '$ocupacion_actual', '$motivo_consulta', '$fecha', '$procedimiento')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
