<?php
//empleados_salva.php
require "Funciones/conecta.php";
$con = conecta();

//Recibe las variables
$nombre         = $_REQUEST['Nombre'];
$codigo         = $_REQUEST["Codigo"];
$descripcion    = $_REQUEST['Descripcion'];
$costo          = $_REQUEST['Costo'];
$stock          = $_REQUEST['Stock'];

$file_name  = $_FILES['Archivo']['name'];       //Nombre real del archivo subido
$file_tmp   = $_FILES['Archivo']['tmp_name'];   //Nombre temporal del archivo para nosotros verlo
$arreglo    = explode(".", $file_name);         //Separa el nombre por . en cada espacio(hace un array)
$len        = count($arreglo);                  //Numero de elementos de nuestro array
$pos        = $len-1;                           //Pocisiona en la posicion ultimo donde esta la extencion del archivo
$ext        = $arreglo[$pos];                   //Extension de nuestro archivo
$dir        = "Archivos/Productos/";                      //Carpeta se guarda el archivo temporal
$file_enc   = md5_file($file_tmp );              //Nombre del archivo con base al contenido que contiene

if ($file_name !=''){                   //Si el archivo es diferente a nada quiere decir que si se subio el archivo
    $fileName1 = "$file_enc.$ext";      //SE le asigna a la variable fileName1 el archivo encriptado con su extension
    copy($file_tmp, $dir.$fileName1);   //Se le define al nuevo nombre del archivo a la carpeta que mencionamos
}

$archivo_n  = $file_name;       //Nombre real del archivo subido
$archivo    = $fileName1;       //Nombre temporal del archivo para nosotros verlo





$sql = "INSERT INTO productos
            (Nombre, Codigo, Descripcion, Costo, Stock, Archivo_n, Archivo)
        VALUES ('$nombre', '$codigo', '$descripcion', '$costo', '$stock',
                '$archivo_n', '$archivo')"; 
                // VALUES son las variables que  debo recibir a comparacion del primer parentesis para los datos de entrada de byadmin
$res = $con->query($sql);

header("Location: productos_lista.php");
?>
