<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="nuevaHistoria.css">
    <link rel="stylesheet" href="/CSS/registro.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <title>Registrar nuevo paciente</title>
  </head>

  <body>
    
    <div class = "Navbar">
      <a href="index.php"><span class="material-symbols-outlined">arrow_back</span></a>
      <h1>Crear Nueva Historia Clínica</h1>
    </div>

    <br>

    <div class="registro">
      <form action="create.php" method="POST">
        
        <div class = "Fecha">
          
          <div>
            <label>Área:</label>
            <div class="radio-group">
              <input type="radio" id="Gine" name="area" value="Ginecología" required>
              <label for="Gine">Ginecología</label>

              <input type="radio" id="Derma" name="area" value="Dermatología" required>
              <label for="Derma">Dermatología</label>
            </div>
          </div>

          <div>
            <label for="fecha">Fecha de consulta:</label>
            <input type="date" id="fecha" name="fecha" required>
          </div>
        </div>
      
        <div class = "Nombres">
          <div>
            <label for="nombre">Nombre(s):</label>
            <input type="text" id="nombre_paciente" name="nombre_paciente" required>
          </div>

          <div>
            <label for="apellido_p">Apellido paterno:</label>
            <input type="text" id="apellido_p" name="apellido_p" required>
          </div>

          <div>
            <label for="apellido_m">Apellido materno:</label>
            <input type="text" id="apellido_m" name="apellido_m" required>
          </div>        
        </div>
         
        <div class = "Fecha">
          <div>
            <label for="fecha_nacimiento">Fecha nacimento:</label>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>
          </div>

          <div>
            <label>Sexo:</label>
            <div class="radio-group">
              <input type="radio" id="sexo" name="sexo" value="H" required>
              <label for="sexo">H</label>
              <input type="radio" id="sexo" name="sexo" value="M" required>
              <label for="sexo">M</label>
            </div>
          </div>
        </div>

        <div class = "Nombres">
          <div>
            <label for="telefono">Teléfono: </label>
            <input type="text" id="telefono" name="telefono" >
          </div>

          <div>
            <label for="ocupacion">Ocupación: </label>
            <input type="text" id="ocupacion" name="ocupacion" >
          </div>

          <div>
            <label for="estado_civil">Estado civil:</label>
            <input type= "text" id="estado_civil" name="estado_civil">
          </div>
        </div>

        <!--REGISTRO DE HISTORIA-->
        <div class = "Datos">
          <div>
            <label for="peso">Peso:</label>
            <input type="number" step ="0.01" id="peso" name="peso">
          </div>

          <div>
            <label for="altura">Altura:</label>
            <input type="number" step ="0.01" id="altura" name="altura">
          </div>

          <div>
            <label for="imc">IMC:</label>
            <input type="number"  step ="0.01" id="imc" name="imc">
          </div>

          <div>
            <label for="igc">IGC:</label>
            <input type="number" step ="0.01" id="igc" name="igc">
          </div>
        </div>

        <label for="motivo_consulta">Motivo de la consulta:</label>
        <textArea type="text" id="motivo_consulta" name="motivo_consulta" required></textArea>

        <label for="observaciones">Observaciones:</label>
        <textArea type="text" id="observaciones" name="observaciones"></textArea>

        <label for="tratamiento">Tratamiento:</label>
        <textArea type="text" id="tratamiento" name="tratamiento" required></textArea>

        
        <!--DOCTOR-->

        <div class = "Botones">
          <input type="submit" value="Crear">
          <a href="index.php" class = "cancelar">Cancelar</a>
        </div>

      </form>

    </div>
  </body>
</html>
