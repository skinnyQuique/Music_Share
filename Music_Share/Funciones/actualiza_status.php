<?php
// Inserta_Producto.php
session_start();

include("conecta.php");
$con = conecta();

$sql = "UPDATE pedidos SET Status = 1";
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