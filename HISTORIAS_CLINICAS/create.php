<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "historias_clinicas";
//proteger
session_start();

if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
    header("Location: create.php");
    exit;
}
// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Iniciar transacción
    $conn->begin_transaction();

    try {
        // Datos del paciente
        $nombre_paciente = $_POST['nombre_paciente'];
        $apellido_p = $_POST['apellido_p'];
        $apellido_m = $_POST['apellido_m'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $sexo = $_POST['sexo'];
        $telefono = $_POST['telefono'];
        $ocupacion = $_POST['ocupacion'];
        $estado_civil = $_POST['estado_civil'];

        //SELECIONAR DE PACIENTES EL ID DEL PACIENTE Y PASARLE LOS DATOS A CONSULTAR, NOMBRE, APELLIDO Y APELLIDO M
        $sql_verificar = "SELECT id_paciente FROM pacientes 
                  WHERE nombre_paciente = ? AND apellido_p = ? AND apellido_m = ?";
//PREPARA UN STMT PARA VERIFICAR SI ES IGUAL AL SQL DE CONSULTA
$verificar_stmt = $conn->prepare($sql_verificar);
//PASA LOS MARCADORES DE POSICIÓN ASIGNADOS A SU RESPECTIVA VARIABLE, EN ESTE CASO SSS STRING
$verificar_stmt->bind_param("sss", $nombre_paciente, $apellido_p, $apellido_m);
//ESTO ES DE LOS PRIMEROS STMT QUE USAS EN CREATE PARA EJECUTAR
$verificar_stmt->execute();
$verificar_stmt->store_result();


if ($verificar_stmt->num_rows > 0) {
    // VERIFICAR SI YA EXISTEEE
    $verificar_stmt->close();
    $conn->rollback();
    //SCRIPT PARA ALERTAR QUE YA EXISTE
    echo "
    <script>alert('El paciente ya está registrado.'); window.location.href = 'registroPaciente.php';</script>";
    exit();
}
//CIERRA STATEMENT
$verificar_stmt->close();
        // crear paciente
        $sql_paciente = "INSERT INTO pacientes (nombre_paciente, apellido_p, apellido_m, fecha_nacimiento, sexo, telefono, ocupacion, estado_civil)
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $statement = $conn->prepare($sql_paciente);
        $statement->bind_param("ssssssss", $nombre_paciente, $apellido_p, $apellido_m, $fecha_nacimiento, $sexo, $telefono, $ocupacion, $estado_civil);
        $statement->execute();

        // catch / cacth aaaa id paciente
        $id_paciente = $conn->insert_id;

        // Datos de historia
        $fecha = $_POST['fecha'];
        $motivo_consulta = $_POST['motivo_consulta'];      
        $peso = $_POST['peso'];
        $altura = $_POST['altura'];
        $imc = $_POST['imc'];
        $igc = $_POST['igc']; 
$tratamiento = $_POST['tratamiento'];
        $observaciones = $_POST['observaciones']; 
        $area = $_POST['area'];
        $id_doctor = ($area === 'Dermatología') ? 1 : 2;       

        // Insertar historia con id paciente
        $sql_historia = "INSERT INTO historias (id_paciente, fecha, motivo_consulta, peso, altura, imc, igc, tratamiento, observaciones, id_doctor)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$statement2 = $conn->prepare($sql_historia);
$statement2->bind_param("issddddssi", $id_paciente, $fecha, $motivo_consulta, $peso, $altura, $imc, $igc, $tratamiento, $observaciones, $id_doctor);
$statement2->execute();


        $conn->commit();

        header("Location: index.php");
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }

    $statement->close();
    $statement2->close();
    $conn->close();
}
?>

