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
  //fin proteger


  // Crear conexión
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Verificar conexión
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $id = $_GET['id_historia'];

  $sql = "SELECT h.id_historia, h.fecha, h.motivo_consulta, h.peso, h.altura, h.imc, h.igc, h.tratamiento, h.observaciones, 
  p.id_paciente, p.nombre_paciente, p.apellido_p, p.apellido_m,  p.fecha_nacimiento, p.sexo,p.telefono, p.ocupacion, p.estado_civil,
  d.nombre_doctor, d.especialidad
  FROM historias h
  INNER JOIN pacientes p ON h.id_paciente = p.id_paciente
  LEFT JOIN doctor d ON h.id_doctor = d.id_doctor
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
    <link rel="stylesheet" href="/CSS/visualizar.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
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

    <div class = "Navbar">    
      <a href="index.php"><span class="material-symbols-outlined">arrow_back</span></a>
      <h1>Historia Clínica</h1>
    </div>
    
    <br>

    <div class="historias-container">
      <?php
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
              
            //obtener edad
            $año_nacimiento = date("Y", strtotime($row['fecha_nacimiento']));
            $año_hoy = date("Y");
            $edad = $año_hoy - $año_nacimiento;
            //fin edad

            echo "<div class = 'Area'>";
              echo "<p><strong>Doctor:</strong> {$row['nombre_doctor']}</p>";
              echo "<p><strong>Especialidad:</strong> {$row['especialidad']}</p>";
            echo "</div>";

            echo "<br>";
            
            echo "<div> <p><strong>Paciente:</strong> {$row['nombre_paciente']} {$row['apellido_p']} {$row['apellido_m']}</p> </div>";

            echo "<br>";

            echo "<div class = Nombres>";    
              echo "<div> <p><strong>Edad:</strong> {$edad} años</p> </div>";
              echo "<div> <p><strong>Sexo:</strong> {$row['sexo']}</p> </div>";
              echo "<div> <p><strong>Teléfono:</strong> {$row['telefono']}</p> </div>";
              echo "<div> <p><strong>Ocupación:</strong> {$row['ocupacion']}</p> </div>";
              echo "<div> <p><strong>Estado Civil:</strong> {$row['estado_civil']}</p> </div>";
            echo "</div>";

            echo "<br>";

            echo "<div class = 'Medidas'>";
              echo "<div><p><strong>Peso:</strong> " . ($row['peso'] != 0 ? "{$row['peso']} kg" : "") . "</p></div>";
              echo "<div><p><strong>Altura:</strong> " . ($row['altura'] != 0 ? "{$row['altura']} m" : "") . "</p></div>";
              echo "<div><p><strong>IMC:</strong> " . ($row['imc'] != 0 ? "{$row['imc']}" : "") . "</p></div>";
              echo "<div><p><strong>IGC:</strong> " . ($row['igc'] != 0 ? "{$row['igc']}" : "") . "</p></div>";
            echo "</div>";

            echo "<br>";
            
            echo "<p><strong>Motivo de consulta:</strong> {$row['motivo_consulta']}</p>";

            echo "<br>";

            echo "<p><strong>Observaciones:</strong> {$row['observaciones']}</p>";

            echo "<br>";

            echo "<table>
              <tr>
                <th>Fecha</th>
                <th>Tratamiento</th>
              </tr>";
          
              $fechas = explode("\n", $row['fecha']);
              $procedimientos = explode("\n", $row['tratamiento']);
              for ($i = 0; $i < count($fechas); $i++) {
                echo "<tr>
                  <td>{$fechas[$i]}</td>
                  <td>{$procedimientos[$i]}</td>
                </tr>";
              }
            echo "</table>";

            echo "<div class='acciones'>
              <a class='boton' href='update.php?id_historia={$row['id_historia']}'>Agregar consulta</a>
              <a class='eliminar' href='javascript:void(0);' onclick='confirmDeletion({$row['id_historia']});'>Eliminar historia médica</a>
            </div>
            <br>";
          }
        }
        else {
          echo "<p>No hay historias clínicas</p>";
        }
        $conn->close();
      ?>
    </div>
  </body>
</html>
