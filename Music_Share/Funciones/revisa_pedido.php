<?php
// revisar_pedido.php
session_start();
include 'conecta.php';
$con = conecta();

if (isset($_POST['cantidades'])) {
    $cantidades = $_POST['cantidades'];
    foreach ($cantidades as $id_producto => $cantidad) {
        // Realiza la actualización en la base de datos
        $sql = "UPDATE pedidos_productos SET Cantidad = $cantidad WHERE ID = $id_producto";
        $con->query($sql);
    }

    echo 0; // Éxito
} else {
    echo 1; // Error
}

$con->close();

?>

