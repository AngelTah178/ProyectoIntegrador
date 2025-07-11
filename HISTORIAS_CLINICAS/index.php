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
$condicion = "";

if (isset($_GET['buscar']) && !empty(trim($_GET['buscar']))) {
    $busqueda = $conn->real_escape_string($_GET['buscar']);
    $condicion = "WHERE p.nombre_paciente  LIKE '%$busqueda%' OR p.apellido_p LIKE '%$busqueda%'";
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
$condicion
ORDER BY h.id_historia ASC";
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

    <br>

    <div class="contenedorNuevo">
    <a class="nuevo" href="registroPaciente.php">CREAR NUEVA HISTORIA</a>

    </div>

    <div class = "contenedor_Buscador">
        <form method="GET" action="index.php" class="form-buscador">
    <input type="text" name="buscar" placeholder="Buscar">
    <button type="submit">Buscar</button>
</form>

    </div>

    <br>

    <div class="historias-container">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "
                <div class='historias'>
                    <div class='info'>
                        <table> 
                        <p><span class='label'>Nombre Pa:</span> {$row['nombre_paciente']}</p>
                         <td>" . htmlspecialchars($row['fecha']) . "</td>
                        
                        </table>

                        <div class = 'Acciones'>
                        <a class='boton' href='visualizarHistoria.php?id_historia={$row['id_historia']}'>Visualizar historia</a>
                         </div>";


            }
        } else {
            echo "<p>No hay historias clínicas</p>";
        }
        ?>
    </div>

    <?php $conn->close(); ?>
</body>
</html>
