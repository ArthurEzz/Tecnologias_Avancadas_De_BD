<?php
$dbname    = "academico";
$servername = "localhost";
$username  = "usuario";
$password  = "12345";

$con = mysqli_connect($servername, $username, $password, $dbname);

if (!$con) {
    die("<div style='color:red;text-align:center;padding:20px;'>
         ❌ Erro de conexão: " . mysqli_connect_error() . "</div>");
}

mysqli_set_charset($con, "utf8mb4");
?>
