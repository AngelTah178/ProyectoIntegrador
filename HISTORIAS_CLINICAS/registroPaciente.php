<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="nuevaHistoria.css">
    <title>Registrar nuevo paciente</title>
</head>
<body>
    <h1>Crear Nueva Historia Clínica</h1>
    <div class="form-container">
        <form action="create.php" method="POST">
            <label for="nombre">Nombre del paciente:</label>
            <input type="text" id="nombre_paciente" name="nombre_paciente" required>

            <label for="apellido_p">Apellido paterno:</label>
            <input type="text" id="apellido_p" name="apellido_p" required>

            <label for="apellido_m">Apellido materno:</label>
            <input type="text" id="apellido_m" name="apellido_m" required>
            
            <label for="fecha_nacimiento">Fecha nacimento:</label>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>

            <label>Sexo:</label>
            <div class="radio-group">
                <input type="radio" id="sexo" name="sexo" value="H" required>
                <label for="sexo">H</label>
                <input type="radio" id="sexo" name="sexo" value="M" required>
                <label for="sexo">M</label>
            </div>

            <label for="telefono">Telefono: </label>
            <input type="text" id="telefono" name="telefono" >

            <label for="ocupacion">Ocupación: </label>
            <input type="text" id="ocupacion" name="ocupacion" >

            <label for="estado_civil">estado civil:</label>
            <textarea id="estado_civil" name="estado_civil">
                
            </textarea>

<!--FIN DEL FORM DEL REGISTRO DEL PACIENTE-->

             <label for="fecha">Fecha:</label>
            <input type="datetime-local" id="fecha" name="fecha" required>

        <label for="motivo_consulta">Motivo de la consulta:</label>
            <input type="text" id="motivo_consulta" name="motivo_consulta" required>

        <label for="peso">Peso:</label>
            <input type="number" id="peso" name="peso" required>

        <label for="altura">altura:</label>
            <input type="number" id="altura" name="altura" required>
        
        <label for="imc">Imc:</label>
            <input type="number" id="imc" name="imc" required>

        <label for="igc">Igc:</label>
            <input type="number" id="igc" name="igc" required>

        <label for="tratamiento">tratamiento:</label>
            <input type="text" id="tratamiento" name="tratamiento" required>

        <label for="observaciones">Observaciones:</label>
            <input type="text" id="observaciones" name="observaciones" required>
            <input type="submit" value="CREAR">
        </form>

    </div>

</body>
</html>
