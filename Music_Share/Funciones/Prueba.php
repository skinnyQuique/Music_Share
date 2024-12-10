<?php
// Inserta_Producto.php
session_start();

include("conecta.php");
$con = conecta();

$idP = $_REQUEST['ID_Producto']; // Recibe variables
$cantidad = $_REQUEST['Cantidad']; // cacha las variables enviadas
$id_cliente = $_SESSION['IDUser'];

// Consulta si existe un pedido abierto para el usuario Logueado
$sql = "SELECT * FROM pedidos
        WHERE ID_Cliente = $id_cliente AND Status = 0";
$res = $con->query($sql);
$num = $res->num_rows; // 0 ó 1

if ($num == 0) { // Si el ID del usuario no existe en los pedidos se puede realizar
    $fecha = date('Y-m-d H:i:s'); // 2023-12-10 01:49:03
    $sql = "INSERT into pedidos (Fecha, ID_Cliente)
            VALUES ('$fecha', $id_cliente)";
    if ($con->query($sql)) {
        $id_pedido = $con->insert_id; // obtener el ultimo ID insertado
    } else {
        echo "Error al insertar el pedido: " . $con->error;
        exit;
    }
} else { // En caso de encontrarse el usuario en pedidos
    $row = $res->fetch_assoc(); // Obtener la fila del resultado
    $id_pedido = $row['ID']; // pedimos el ID
}

// Obtener precio del producto
$sql = "SELECT Costo FROM productos WHERE ID = $idP";
$res = $con->query($sql);
$row = $res->fetch_assoc(); // Obtener la fila del resultado
$precio = $row['Costo'];

// Modificar el precio según la cantidad
$precio_total = $precio * $cantidad;

// Verificar si ya se está pidiendo ese producto
$sql = "SELECT * FROM pedidos_productos
        WHERE ID_Producto = $idP AND ID_Pedido = $id_pedido";
$res = $con->query($sql);
$num = $res->num_rows;

if ($num == 0) {
    // Insertar producto en el pedido
    $sql = "INSERT INTO pedidos_productos (ID_Pedido, ID_Producto, Cantidad, Precio)
            VALUES ($id_pedido, $idP, $cantidad, $precio_total)";
} else {
    // Actualizar cantidad y precio si el producto ya existe en el pedido
    $sql = "UPDATE pedidos_productos SET Cantidad = Cantidad + $cantidad, Precio = Precio + $precio_total
            WHERE ID_Producto = $idP AND ID_Pedido = $id_pedido";
}

if ($con->query($sql)) {
    echo 1;
} else {
    echo "Error al insertar/actualizar el producto en pedidos_productos: " . $con->error;
}

$con->close();
?>





