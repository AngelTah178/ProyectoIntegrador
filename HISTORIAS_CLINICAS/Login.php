<?php
  session_start();

  $pin_guardado = "clinica123"; 

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pin_ingresado = $_POST['pin'];

    if ($pin_ingresado === $pin_guardado) {
      $_SESSION['autenticado'] = true;
      header("Location: index.php"); 
      exit;
    } 
    else {
      header("Location: index.html?error=1");
      exit;
    }
  }
?>
