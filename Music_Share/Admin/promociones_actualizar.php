<?php
//promociones_actualizar.php
require "Funciones/conecta.php";
$con = conecta();

// Recibe las variables
$id         = $_POST['ID'];
$nombre     = $_POST['Nombre'];


// Verificar si se ha cargado un nuevo archivo
if ($_FILES['Archivo']['name'] != '') {
    $file_name  = $_FILES['Archivo']['name'];       //Nombre real del archivo subido
    $file_tmp   = $_FILES['Archivo']['tmp_name'];   //Nombre temporal del archivo para nosotros verlo
    $arreglo    = explode(".", $file_name);         //Separa el nombre por . en cada espacio(hace un array)
    $len        = count($arreglo);                  //Numero de elementos de nuestro array
    $pos        = $len-1;                           //Pocisiona en la posicion ultimo donde esta la extencion del archivo
    $ext        = $arreglo[$pos];                   //Extension de nuestro archivo
    $dir        = "Archivos/Promociones/";                      //Carpeta se guarda el archivo temporal
    $file_enc   = md5_file($file_tmp );              //Nombre del archivo con base al contenido que contiene

    if ($file_name !=''){                   //Si el archivo es diferente a nada quiere decir que si se subio el archivo
        $fileName1 = "$file_enc.$ext";      //SE le asigna a la variable fileName1 el archivo encriptado con su extension
        copy($file_tmp, $dir.$fileName1);   //Se le define al nuevo nombre del archivo a la carpeta que mencionamos
    }
    $archivo    = $fileName1;   
} else {
    // Si no se carga un nuevo archivo, conservar el archivo existente
    $archivo    = mysqli_real_escape_string($con,$_POST["Archivo_Actual_tmp"]); 
}

$sql = "UPDATE promociones SET
            Nombre          = '$nombre', 
            Archivo         = '$archivo'
        WHERE ID = $id";

$res = $con->query($sql);

header("Location: promociones_lista.php");
?>
