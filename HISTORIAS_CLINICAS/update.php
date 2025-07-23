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

    // DATOS DE PACIENTE
    $nombre = $_POST['nombre_paciente'];
    $telefono = $_POST['telefono'];
    $genero = $_POST['genero'];
    $ocupacion = $_POST['ocupacion_actual'];

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

    // Actualizar paciente
    $sql_p = "UPDATE pacientes SET 
                nombre_paciente = ?, 
                telefono = ?, 
                sexo = ?, 
                ocupacion = ?
              WHERE id_paciente = ?";
    $stmt_p = $conn->prepare($sql_p);
    $stmt_p->bind_param("ssssi", $nombre, $telefono, $genero, $ocupacion, $id_paciente);
    $stmt_p->execute();

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
    } else {
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
        } else {
            echo "No se encontró la historia clínica.";
            exit;
        }
    } else {
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
    <title>Actualizar Historia Clínica</title>
</head>
<body>
    <h1>Actualizar Historia Clínica</h1>
    <div class="form-container">
        <form action="update.php" method="POST">
            <input type="hidden" name="id_historia" value="<?php echo htmlspecialchars($row['id_historia']); ?>">

            <label for="nombre_paciente">Nombre del paciente:</label>
            <input type="text" id="nombre_paciente" name="nombre_paciente" value="<?php echo htmlspecialchars($row['nombre_paciente']); ?>">

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($row['telefono']); ?>">

            <label>Género:</label>
            <div class="radio-group">
                <input type="radio" id="genero_h" name="genero" value="H" <?php echo ($row['sexo'] == 'H') ? 'checked' : ''; ?>>
                <label for="genero_h">H</label>
                <input type="radio" id="genero_m" name="genero" value="M" <?php echo ($row['sexo'] == 'M') ? 'checked' : ''; ?>>
                <label for="genero_m">M</label>
            </div>

            <label for="ocupacion_actual">Ocupación Actual:</label>
            <input type="text" id="ocupacion_actual" name="ocupacion_actual" value="<?php echo htmlspecialchars($row['ocupacion']); ?>">

            <label for="motivo_consulta">Motivo de Consulta:</label>
            <textarea id="motivo_consulta" name="motivo_consulta" required><?php echo htmlspecialchars($row['motivo_consulta']); ?></textarea>

             <label for="peso">Peso:</label>
            <textarea id="peso" name="peso"><?php echo htmlspecialchars($row['peso']); ?></textarea>

             <label for="altura">Altura:</label>
            <textarea id="altura" name="altura"><?php echo htmlspecialchars($row['altura']); ?></textarea>

             <label for="imc">IMC:</label>
            <textarea id="imc" name="imc"><?php echo htmlspecialchars($row['imc']); ?></textarea>

             <label for="igc">IGC:</label>
            <textarea id="igc" name="igc"><?php echo htmlspecialchars($row['igc']); ?></textarea>

            <label for="nueva_fecha">Agregar Nueva Fecha:</label>
            <input type="date" id="nueva_fecha" name="nueva_fecha" required>

            <label for="nuevo_procedimiento">Agregar Nuevo Procedimiento y/o tratamiento:</label>
            <textarea id="nuevo_procedimiento" name="nuevo_procedimiento" required></textarea>

             <label for="observaciones">Observaciones:</label>
            <textarea id="observaciones" name="observaciones"><?php echo htmlspecialchars($row['observaciones']); ?></textarea>

            <input type="submit" value="ACTUALIZAR">
        </form>
    </div>
</body>
</html>
