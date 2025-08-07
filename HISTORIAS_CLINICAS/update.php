<?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "historias_clinicas";

  $conn = new mysqli($servername, $username, $password, $dbname);
  $conn->set_charset("utf8");

  session_start();
  if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
    header("Location: update.php");
    exit;
  }

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_historia = $_POST['id_historia'];

    // DATOS DE HISTORIA
    $motivo_consulta = $_POST['motivo_consulta'];
    $peso = $_POST['peso'];
    $altura = $_POST['altura'];
    $imc= $_POST['imc'];
    $igc = $_POST['igc'];
    $observaciones = $_POST['observaciones'];

    $nueva_fecha = $_POST['nueva_fecha'];
    $nuevo_procedimiento = $_POST['nuevo_procedimiento'];

    // Obtener historia actual
    $sql = "SELECT * FROM historias WHERE id_historia = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_historia);
    $stmt->execute();
    $historia = $stmt->get_result()->fetch_assoc();

    if (!$historia) {
      echo "No se encontró la historia clínica.";
      exit;
    }

    $id_paciente = $historia['id_paciente'];

    // Obtener datos existentes
    $fecha_existente = $historia['fecha'];
    $procedimiento_existente = $historia['tratamiento'];

    // Concatenar nuevas fechas y procedimientos con los existentes
    $fecha_actualizada = !empty($nueva_fecha) 
    ? ($fecha_existente ? $fecha_existente . "\n" . $nueva_fecha : $nueva_fecha) 
    : $fecha_existente;

    $procedimiento_actualizado = !empty($nuevo_procedimiento) 
    ? ($procedimiento_existente ? $procedimiento_existente . "\n" . $nuevo_procedimiento : $nuevo_procedimiento) 
    : $procedimiento_existente;


    // Actualizar historia
    $sql_h = "UPDATE historias SET 
    motivo_consulta = ?, 
    peso = ?, 
    altura = ?, 
    imc = ?, 
    igc = ?, 
    fecha = ?, 
    tratamiento = ?,
    observaciones = ?
    WHERE id_historia = ?";
    $stmt_h = $conn->prepare($sql_h);
    $stmt_h->bind_param("sddddsssi", 
      $motivo_consulta, 
      $peso, 
      $altura, 
      $imc, 
      $igc, 
      $fecha_actualizada, 
      $procedimiento_actualizado,
      $observaciones, 
      $id_historia
    );

    
    if ($stmt_h->execute()) {
      header("Location: index.php");
      exit;
    } 
    else {
      echo "Error al actualizar historia: " . $conn->error;
    }

    $stmt->close();
    $stmt_p->close();
    $stmt_h->close();
    $conn->close();
  }

  // Carga de datos para mostrar formulario en GET
  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['id_historia'])) {
      $id_historia = $_GET['id_historia'];

      $sql = "SELECT h.*, p.* FROM historias h 
      JOIN pacientes p ON h.id_paciente = p.id_paciente 
      WHERE h.id_historia = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $id_historia);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
      } 
      else {
        echo "No se encontró la historia clínica.";
        exit;
      }
    } 
    else {
      echo "ID no especificado.";
      exit;
    }
  }
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="update.css" />
    <link rel="stylesheet" href="/CSS/update.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <title>Actualizar Historia Clínica</title>
  </head>

  <body>
    <div class = "Navbar">
      <a href="index.php"><span class="material-symbols-outlined">arrow_back</span></a>
      <h1>Actualizar Historia Clínica</h1>
    </div>
    <div class="form-container">

      <form action="update.php" method="POST">
        <input type="hidden" name="id_historia" value="<?php echo htmlspecialchars($row['id_historia']); ?>">

        <div class = "Fecha">
          <label for="nueva_fecha">Nueva fecha:</label>
          <input type="date" id="nueva_fecha" name="nueva_fecha" required>
        </div>

        <label for="motivo_consulta">Motivo de consulta:</label>
        <textarea id="motivo_consulta" name="motivo_consulta" required><?php echo htmlspecialchars($row['motivo_consulta']); ?></textarea>

        <div class = "Datos">
          <div>
            <label for="peso">Peso:</label>
            <input type = "number" step = "0.01" id="peso" name="peso" value = "<?php echo htmlspecialchars($row['peso']); ?>">
          </div>

          <div>
            <label for="altura">Altura:</label>
            <input type = "number" step = "0.01" id="altura" name="altura" value = "<?php echo htmlspecialchars($row['altura']); ?>">
          </div>
          
          <div>
            <label for="imc">IMC:</label>
            <input type = "number" step = "0.01" id="imc" name="imc" value = "<?php echo htmlspecialchars($row['imc']); ?>">
          </div>

          <div>
            <label for="igc">IGC:</label>
            <input type = "number" step = "0.01" id="igc" name="igc" value = "<?php echo htmlspecialchars($row['igc']); ?>">
          </div>
        </div>
        
        <label for="nuevo_procedimiento">Nuevo tratamiento:</label>
        <textarea id="nuevo_procedimiento" name="nuevo_procedimiento" required></textarea>

        <label for="observaciones">Observaciones:</label>
        <textarea id="observaciones" name="observaciones"><?php echo htmlspecialchars($row['observaciones']); ?></textarea>

        <div class = "Botones">
          <input type="submit" value="Agregar">
          <a href="index.php" class = "cancelar">Cancelar</a>
        </div>
      </form>
    </div>
  </body>
</html>
