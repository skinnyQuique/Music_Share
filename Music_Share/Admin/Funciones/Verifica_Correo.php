<?php
//VerificaCorreo.php
require "conecta.php";
$con = conecta();

// Recibe variables
$correo = $_REQUEST['Correo'];


$sql = "SELECT COUNT(*) as num FROM empleados WHERE TRIM(Correo) = '$correo'";
$res = $con->query($sql);

echo ($res) ? $res->fetch_assoc()['num'] : "Error en la consulta SQL: " . $con->error;

?>