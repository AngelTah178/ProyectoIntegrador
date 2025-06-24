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

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM historias WHERE id=$id";
        $result = $conn->query($sql);

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $edad = $_POST['edad'];
    $telefono = $_POST['telefono'];
    $genero = $_POST['genero'];
    $lugar_residencia = $_POST['lugar_residencia'];
    $ocupacion_actual = $_POST['ocupacion_actual'];
    $motivo_consulta = $_POST['motivo_consulta'];

    // Obtener nuevas fechas y procedimientos
    $nueva_fecha = $_POST['nueva_fecha'];
    $nuevo_procedimiento = $_POST['nuevo_procedimiento'];

    // Obtener fechas y procedimientos existentes
    $sql = "SELECT fecha, procedimiento FROM historias WHERE id=$id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $existingData = $result->fetch_assoc();
        $fecha_existente = $existingData['fecha'];
        $procedimiento_existente = $existingData['procedimiento'];
    } else {
        echo "No se encontró la historia clínica.";
        exit;
    }

    // Concatenar nuevas fechas y procedimientos con los existentes
    $fecha = !empty($nueva_fecha) ? ($fecha_existente ? $fecha_existente . "\n" . $nueva_fecha : $nueva_fecha) : $fecha_existente;
    $procedimiento = !empty($nuevo_procedimiento) ? ($procedimiento_existente ? $procedimiento_existente . "\n" . $nuevo_procedimiento : $nuevo_procedimiento) : $procedimiento_existente;

    // Actualizar la historia clínica en la base de datos
    $sql = "UPDATE historias SET 
                nombre='$nombre', 
                edad='$edad', 
                telefono='$telefono', 
                genero='$genero', 
                lugar_residencia='$lugar_residencia', 
                ocupacion_actual='$ocupacion_actual', 
                motivo_consulta='$motivo_consulta', 
                fecha='$fecha', 
                procedimiento='$procedimiento' 
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="update.css">
    <title>Agregar Historia Clínica</title>
</head>
<body>
    <h1>Agregar Historia Clínica</h1>
    <div class="form-container">
        <form action="update.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">

            <label for="nombre">Nombre del paciente:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($row['nombre']); ?>" required>

            <label for="edad">Edad:</label>
            <input type="number" id="edad" name="edad" value="<?php echo htmlspecialchars($row['edad']); ?>" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($row['telefono']); ?>" >

            <label>Género:</label>
            <div class="radio-group">
                <input type="radio" id="genero_h" name="genero" value="H" <?php echo $row['genero'] == 'H' ? 'checked' : ''; ?>>
                <label for="genero_h">H</label>
                <input type="radio" id="genero_m" name="genero" value="M" <?php echo $row['genero'] == 'M' ? 'checked' : ''; ?>>
                <label for="genero_m">M</label>
            </div>

            <label for="lugar_residencia">Lugar de Residencia:</label>
            <input type="text" id="lugar_residencia" name="lugar_residencia" value="<?php echo htmlspecialchars($row['lugar_residencia']); ?>" >

            <label for="ocupacion_actual">Ocupación Actual:</label>
            <input type="text" id="ocupacion_actual" name="ocupacion_actual" value="<?php echo htmlspecialchars($row['ocupacion_actual']); ?>" >

            <label for="motivo_consulta">Motivo de Consulta:</label>
            <textarea id="motivo_consulta" name="motivo_consulta" required><?php echo htmlspecialchars($row['motivo_consulta']); ?></textarea>

            <label for="nueva_fecha">Agregar Nueva Fecha:</label>
            <input type="date" id="nueva_fecha" name="nueva_fecha">

            <label for="nuevo_procedimiento">Agregar Nuevo Procedimiento y/o tratamiento:</label>
            <textarea id="nuevo_procedimiento" name="nuevo_procedimiento"></textarea>

            <input type="submit" value="AGREGAR">
        </form>
    </div>
</body>
</html>

