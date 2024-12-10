<?php
//promociones_salva.php
require "Funciones/conecta.php";
$con = conecta();

//Recibe las variables
$nombreimg         = $_REQUEST['NombreImg'];

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

$archivo  = $fileName1;       //Nombre real del archivo subido





$sql = "INSERT INTO promociones
            (Nombre, Archivo)
        VALUES ('$nombreimg', '$archivo')"; 
                // VALUES son las variables que  debo recibir a comparacion del primer parentesis para los datos de entrada de byadmin
$res = $con->query($sql);


header("Location: promociones_lista.php");
?>
