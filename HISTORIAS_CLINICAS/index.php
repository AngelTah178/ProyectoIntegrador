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


$sql = "
SELECT h.*, 
       p.nombre_paciente, 
       p.apellido_p, 
       p.apellido_m, 
       p.fecha_nacimiento, 
       p.sexo, 
       p.telefono, 
       p.ocupacion, 
       p.estado_civil
FROM historias h
JOIN pacientes p ON h.id_paciente = p.id_paciente
ORDER BY h.id_historia ASC";
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
    <a class="nuevo" href="registroPaciente.php">CREAR NUEVA HISTORIA</a>

    </div>
    <br>

    <div class="historias-container">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "
                <div class='historias'>
                    <div class='info'>
                        
                        <p><span class='label'>Nombre del paciente:</span> {$row['nombre_paciente']}</p>
                        <p><span class='label'>Apellido paterno:</span> {$row['apellido_p']}</p>
                        <p><span class='label'>Apellido materno:</span> {$row['apellido_m']}</p>
                        <p><span class='label'>Fecha nacimiento:</span> {$row['fecha_nacimiento']}</p>
                        <p><span class='label'>Sexo:</span> {$row['sexo']}</p>
                        <p><span class='label'>telefono:</span> {$row['telefono']}</p>
                        <p><span class='label'>Ocupación:</span> {$row['ocupacion']}</p>
                        <p><span class='label'>Estado civil:</span> {$row['estado_civil']}</p>
                        <p><span class='label'>Motivo consulta:</span> {$row['motivo_consulta']}</p>
                        <p><span class='label'>Peso:</span> {$row['peso']}</p>
                        <p><span class='label'>IMC:</span> {$row['imc']}</p>
                        <p><span class='label'>IGC:</span> {$row['igc']}</p>
                        <p><span class='label'>Observaciones:</span> {$row['observaciones']}</p>



                    </div>
                    <table>
                        <tr>
                            <th>Fecha</th>
                            <th>Procedimiento y/o tratamiento</th>
                        </tr>";

    
                    echo "<tr>
                              <td>" . htmlspecialchars($row['fecha']) . "</td>
        <td>" . htmlspecialchars($row['tratamiento']) . "</td>
                          </tr>";
                

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
