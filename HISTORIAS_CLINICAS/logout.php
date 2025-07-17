<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "historias_clinicas";

session_start();
session_destroy();
header("Location: index.html");
exit;

?>