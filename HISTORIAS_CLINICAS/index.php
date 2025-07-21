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
$condicion = "";

if (isset($_GET['buscar']) && !empty(trim($_GET['buscar']))) {
    $busqueda = $conn->real_escape_string($_GET['buscar']);
    $condicion = "WHERE p.nombre_paciente  LIKE '%$busqueda%' OR p.apellido_p LIKE '%$busqueda%'";
}

$por_pagina = 10; // cantidad de resultados por página

// Página actual (desde $_GET), por defecto es 1
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($pagina - 1) * $por_pagina;
//fin de pag actual

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
ORDER BY h.id_historia ASC
   LIMIT $inicio, $por_pagina";
$result = $conn->query($sql);

///
$total_query = "SELECT COUNT(*) as total FROM historias";
$total_result = $conn->query($total_query);
$total_filas = $total_result->fetch_assoc()['total'];

// Total de páginas
$total_paginas = ceil($total_filas / $por_pagina);


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
<a href="logout.php">Cerrar sesión</a>

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

                //imrpimir ultima fecha
                $fechas = explode("\n", $row['fecha']);
                $ultima_fecha = htmlspecialchars(trim(end($fechas)));
                //fin
                
                echo "
                <div class='historias'>
                    <div class='info'>
                        <table> 
                        <p><span class='label'>Nombre completo:</span> {$row['nombre_paciente']} {$row['apellido_p']} {$row['apellido_m']}</p>

                        
                         <td>" . htmlspecialchars( $ultima_fecha) . "</td>
                        
                        </table>

                        <div class = 'Acciones'>
                        <a class='boton' href='visualizarHistoria.php?id_historia={$row['id_historia']}'>Visualizar historia</a>
                         </div>";

      


            }
                               // Mostrar botones
echo "<div class='paginacion'>";
for ($i = 1; $i <= $total_paginas; $i++) {
    $active = ($i == $pagina) ? "style='font-weight:bold;'" : "";
    echo "<a href='index.php?pagina=$i' $active> $i </a>";
}
echo "</div>";
        } else {
            echo "<p>No hay historias clínicas</p>";
        }
        ?>
    </div>

    <?php $conn->close(); ?>
</body>
</html>
