<?php
//empleados_actualizar.php
require "Funciones/conecta.php";
$con = conecta();

// Recibe las variables
$id         = $_POST['ID'];
$nombre     = $_POST['Nombre'];
$apellidos  = $_POST["Apellidos"];
$correo     = $_POST['Correo'];
$pass       = $_POST['Pass'];
$rol        = $_POST['Rol'];
$passEnc    = md5($pass);    // Genera una cadena encriptada para la seguridad


// Verificar si se ha cargado un nuevo archivo
if ($_FILES['Archivo']['name'] != '') {
    $file_name  = $_FILES['Archivo']['name'];
    $file_tmp   = $_FILES['Archivo']['tmp_name'];
    $arreglo    = explode(".", $file_name);
    $len        = count($arreglo);
    $pos        = $len - 1;
    $ext        = $arreglo[$pos];
    $dir        = "Archivos/Empleados/";
    $file_enc   = md5_file($file_tmp);
    $fileName1  = "$id.$ext";               // Usar el ID del empleado como parte del nombre del archivo

    if ($file_name !=''){                   //Si el archivo es diferente a nada quiere decir que si se subio el archivo
        $fileName1 = "$file_enc.$ext";      //SE le asigna a la variable fileName1 el archivo encriptado con su extension
        copy($file_tmp, $dir.$fileName1);   //Se le define al nuevo nombre del archivo a la carpeta que mencionamos
    } 
    $archivo_n  = $file_name;
    $archivo    = $fileName1;   
} else {
    // Si no se carga un nuevo archivo, conservar el archivo existente
    $archivo_n  = $_POST["Archivo_Actual"];
    $archivo    = $_POST["Archivo_Actual_tmp"]; 
}

$sql = "UPDATE empleados SET
            Nombre      = '$nombre', 
            Apellidos   = '$apellidos', 
            Correo      = '$correo', 
            Pass        = '$passEnc', 
            Rol         = $rol, 
            Archivo_n   = '$archivo_n', 
            Archivo     = '$archivo'
        WHERE ID = $id";

$res = $con->query($sql);

header("Location: empleados_lista.php");
?>
