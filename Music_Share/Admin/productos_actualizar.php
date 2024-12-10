<?php
//productos_actualizar.php
require "Funciones/conecta.php";
$con = conecta();

// Recibe las variables
$id             = $_POST['ID'];
$nombre         = mysqli_real_escape_string($con, $_POST['Nombre']);
$codigo         = $_POST['Codigo'];
$descripcion    = $_POST['Descripcion'];
$costo          = $_POST["Costo"];
$stock          = $_POST['Stock'];

// Verificar si se ha cargado un nuevo archivo
if ($_FILES['Archivo']['name'] != '') {
    $file_name  = mysqli_real_escape_string($con,$_FILES['Archivo']['name']);
    $file_tmp   = mysqli_real_escape_string($con,$_FILES['Archivo']['tmp_name']);
    $arreglo    = explode(".", $file_name);
    $len        = count($arreglo);
    $pos        = $len - 1;
    $ext        = $arreglo[$pos];
    $dir        = "Archivos/Productos/";
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
    $archivo_n  = mysqli_real_escape_string($con,$_POST["Archivo_Actual"]);
    $archivo    = mysqli_real_escape_string($con,$_POST["Archivo_Actual_tmp"]); 
}

$sql = "UPDATE productos SET
            Nombre          = '$nombre', 
            Codigo          = '$codigo', 
            Costo           = '$costo', 
            Stock           = '$stock', 
            Descripcion     = '$descripcion', 
            Archivo_n       = '$archivo_n', 
            Archivo         = '$archivo'
        WHERE ID = $id";

$res = $con->query($sql);

header("Location: productos_lista.php");
?>
