<?php
//empleados_elimina.php
require "Funciones/conecta.php";
$con = conecta();

$id = $_REQUEST['ID'];

//$sql = "DELETE FROM empleados WHERE ID = $id";    <---------------------- ESTE Elimina toda la fila
$sql = "UPDATE promociones SET Eliminado = 1 WHERE ID = $id"; //<----------------- Este actualiza el elimina de 0 (aparece) a 1 (oculto)
$res = $con->query($sql);


if ($res) {
    // Operación exitosa, se envía una respuesta de "0" al cliente
    echo '0';
} else {
    // Error en la operación, se envía una respuesta de "1" al cliente
    echo '1';
}
//header("Location: empleados_lista.php");
?>

