<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "historias_clinicas";
//proteger
session_start();

if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
    header("Location: index.php");
    exit;
}
// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$id = $_GET['id_historia'];

$sql = "SELECT h.id_historia, h.fecha, h.motivo_consulta, h.peso, h.altura, h.imc, h.igc, h.tratamiento, h.observaciones, 
               p.id_paciente, p.nombre_paciente,p.fecha_nacimiento, p.sexo
        FROM historias h
        INNER JOIN pacientes p ON h.id_paciente = p.id_paciente
        WHERE h.id_historia = $id";
$result = $conn->query($sql);

?>
<!--FIN DE PHP PARA MOSTRAR-->
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

</form>

    </div>

    <br>

    <div class="historias-container">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                
    echo "<h3>Datos del Paciente</h3>";
    echo "<p><strong>Nombre:</strong> " . $row['nombre_paciente'] . "</p>";
    echo "<p><strong>fecha_nacimiento:</strong> " . $row['fecha_nacimiento'] . "</p>";
    echo "<p><strong>Sexo:</strong> " . $row['sexo'] . "</p>";
               
    echo "<h2>Historia Clínica</h2>";

    echo "<p><strong>Motivo consulta:</strong> " . $row['motivo_consulta'] . "</p>";
    echo "<p><strong>Peso:</strong> " . $row['peso'] . "</p>";
    echo "<p><strong>Altura:</strong> " . $row['altura'] . "</p>";
    echo "<p><strong>imc:</strong> " . $row['imc'] . "</p>";
    echo "<p><strong>igc:</strong> " . $row['igc'] . "</p>";
    echo "<p><strong>Observaciones:</strong> " . $row['observaciones'] . "</p>

      <table>
                        <tr>
                            <th>Fecha</th>
                            <th>Procedimiento y/o tratamiento</th>
                        </tr>";
    $fechas = explode("\n", $row['fecha']);
                $procedimientos = explode("\n", $row['tratamiento']);
                for ($i = 0; $i < count($fechas); $i++) {
                    echo "<tr>
                            <td>{$fechas[$i]}</td>
                            <td>{$procedimientos[$i]}</td>
                          </tr>";
                }



    
    
                echo "</table>
                <br>
                    <div class='acciones'>
                        <a class='boton' href='update.php?id_historia={$row['id_historia']}'>Modificar consulta</a>
                        <a class='boton' href='javascript:void(0);' onclick='confirmDeletion(" . htmlspecialchars($row['id_historia']) . ");'>ELIMINAR HISTORIA MÉDICA</a>
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
