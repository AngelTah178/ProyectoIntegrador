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

$sql = "SELECT * FROM historias ORDER BY nombre ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="index.css" rel="stylesheet" type="text/css">
    <title>Historias Clínicas Dermatología</title>
    <script>
        function confirmDeletion(id) {
            if (confirm("¿Estás seguro de que deseas eliminar esta historia clínica?")) {
                window.location.href = "delete.php?id=" + id;
            }
        }
    </script>
</head>
<body>
    <header class="titulo">
        <h1>Historias Clínicas Dermatología</h1>
    </header>

    <br>

    <div class="contenedorNuevo">
    <a class="nuevo" href="nuevaHistoria.php">CREAR NUEVA HISTORIA</a>

    </div>
    <br>

    <div class="historias-container">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "
                <div class='historias'>
                    <div class='info'>
                        
                        <p><span class='label'>Nombre del paciente:</span> {$row['nombre']}</p>
                        <p><span class='label'>Edad:</span> {$row['edad']}</p>
                        <p><span class='label'>Teléfono:</span> {$row['telefono']}</p>
                        <p><span class='label'>Género:</span> {$row['genero']}</p>
                        <p><span class='label'>Lugar de residencia:</span> {$row['lugar_residencia']}</p>
                        <p><span class='label'>Ocupación actual:</span> {$row['ocupacion_actual']}</p>
                        <p><span class='label'>Motivo de la consulta:</span> {$row['motivo_consulta']}</p>
                    </div>
                    <table>
                        <tr>
                            <th>Fecha</th>
                            <th>Procedimiento y/o tratamiento</th>
                        </tr>";

                $fechas = explode("\n", $row['fecha']);
                $procedimientos = explode("\n", $row['procedimiento']);
                for ($i = 0; $i < count($fechas); $i++) {
                    echo "<tr>
                            <td>{$fechas[$i]}</td>
                            <td>{$procedimientos[$i]}</td>
                          </tr>";
                }

                echo "</table>
                <br>
                    <div class='acciones'>
                        <a class='boton' href='update.php?id={$row['id']}'>AGREGAR CONSULTA</a>
                        <a class='boton' href='javascript:void(0);' onclick='confirmDeletion(" . htmlspecialchars($row['id']) . ");'>ELIMINAR HISTORIA MÉDICA</a>
                    </div>
                </div>
                <br>";
            }
        } else {
            echo "<p>No hay historias clínicas</p>";
        }
        ?>
    </div>

    <?php $conn->close(); ?>
</body>
</html>
