<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="nuevaHistoria.css">
    <title>Crear Nueva Historia Clínica</title>
</head>
<body>
    <h1>Crear Nueva Historia Clínica</h1>
    <div class="form-container">
        <form action="create.php" method="POST">
            <label for="nombre">Nombre del paciente:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="edad">Edad:</label>
            <input type="number" id="edad" name="edad" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono">

            <label>Género:</label>
            <div class="radio-group">
                <input type="radio" id="genero_h" name="genero" value="H" required>
                <label for="genero_h">H</label>
                <input type="radio" id="genero_m" name="genero" value="M" required>
                <label for="genero_m">M</label>
            </div>

            <label for="lugar_residencia">Lugar de Residencia:</label>
            <input type="text" id="lugar_residencia" name="lugar_residencia" >

            <label for="ocupacion_actual">Ocupación Actual:</label>
            <input type="text" id="ocupacion_actual" name="ocupacion_actual" >

            <label for="motivo_consulta">Motivo de Consulta:</label>
            <textarea id="motivo_consulta" name="motivo_consulta" required></textarea>

            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" required>

            <label for="procedimiento">Procedimiento y/o tratamiento:</label>
            <textarea id="procedimiento" name="procedimiento" required></textarea>

            <input type="submit" value="CREAR">
        </form>
    </div>
</body>
</html>
