<?php
//empleados_salva.php
require "funciones/conecta.php";

function generarNombreArchivo($archivo)
{
    $arreglo = explode(".", $archivo['name']);
    $len = count($arreglo);
    $pos = $len - 1;
    $ext = $arreglo[$pos];
    $file_enc = md5_file($archivo['tmp_name']);
    return "$file_enc.$ext";
}

function subirArchivo($archivo, $dir, $nombreArchivo)
{
    move_uploaded_file($archivo['tmp_name'], $dir . $nombreArchivo);
}

$con = conecta();

$nombre = $_REQUEST['Nombre'];
$apellidos = $_REQUEST["Apellidos"];
$correo = $_REQUEST['Correo'];
$pass = $_REQUEST['Pass'];
$rol = $_REQUEST['Rol'];
$passEnc = md5($pass);

$archivo = $_FILES['Archivo'];

if (!empty($archivo['name'])) {
    $nombreArchivo = generarNombreArchivo($archivo);
    subirArchivo($archivo, "Archivos/", $nombreArchivo);
} else {
    $nombreArchivo = '';
}

$sql = "INSERT INTO empleados
        (Nombre, Apellidos, Correo, Pass, Rol, Archivo_n, Archivo)
        VALUES ('$nombre', '$apellidos', '$correo', '$passEnc', $rol,
                '$nombreArchivo', '$archivo')";
$res = $con->query($sql);

header("Location: empleados_lista.php");
?>
