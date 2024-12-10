<?php
//Verifica_Codigo.php
require "conecta.php";
$con = conecta();

// Recibe variables
$codigo = $_REQUEST['Codigo'];


$sql = "SELECT COUNT(*) as num FROM productos WHERE TRIM(Codigo) = '$codigo'";
$res = $con->query($sql);

echo ($res) ? $res->fetch_assoc()['num'] : "Error en la consulta SQL: " . $con->error;

?>