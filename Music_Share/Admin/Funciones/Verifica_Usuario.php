<?php
//VerificaCorreo.php
session_start();
require "conecta.php";
$con = conecta();

// Recibe variables
$correo = $_REQUEST['Correo'];
$pass = md5($_REQUEST['Pass']);


$sql = "SELECT * FROM empleados WHERE Correo = '$correo' AND Pass = '$pass' AND Status = 1 AND Eliminado = 0";
$res = $con->query($sql);
$num = $res->num_rows;

if($num == 1) {
    $row        = $res->fetch_array();
    $id         = $row["ID"];
    $nombre     = $row["Nombre"];
    $apellidos  = $row["Apellidos"];
    $correo     = $row["Correo"];
    //
    $_SESSION['IDUser']     = $id;
    $_SESSION['NombreUser'] = $nombre;
    $_SESSION['CorreoUser'] = $correo;
}

echo $num;


?>