<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "historias_clinicas";
//proteger
session_start();

if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
    header("Location: delete.php");
    exit;
}
// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = ($_GET['id']); 
//tomar el id del paciente, seleccionas de la tabla historias donde mi id = el putisimo id
$sql_get_paciente = "SELECT id_paciente FROM historias WHERE id_historia = $id";
$result = $conn->query($sql_get_paciente);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id_paciente = $row['id_paciente'];
    //variable id es igual a la columna id paciente

    //delete de
    $sql_delete_historia = "DELETE FROM historias WHERE id_historia = $id";
    $conn->query($sql_delete_historia);

    $sql_delete_paciente = "DELETE FROM pacientes WHERE id_paciente = $id_paciente";
    $conn->query($sql_delete_paciente);

    header("Location: index.php");
    exit();
} else {
    echo "No se encontró la historia clínica con ID: $id";
}

$conn->close();
?>

