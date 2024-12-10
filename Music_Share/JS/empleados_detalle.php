<?php
//empleados_detalles.php
require "Funciones/conecta.php";

// Verificar la existencia del parámetro ID
if (!isset($_GET['ID']) || !is_numeric($_GET['ID'])) {
    // Manejar el error, redireccionar o mostrar un mensaje apropiado
    echo "ID no válido";
    exit;
}
$id = $_GET['ID'];
$con = conecta();

// Consulta preparada para prevenir inyección SQL
$sql = "SELECT * FROM empleados WHERE ID = ?";
$stmt = $con->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    $res = $stmt->get_result();

    if ($res) {
        // Verificar si se obtuvieron resultados
        if ($res->num_rows > 0) {
            $row = $res->fetch_array();
            
            // Recibir las variables
            $nombre     = htmlspecialchars($row["Nombre"]);
            $apellidos  = htmlspecialchars($row["Apellidos"]);
            $correo     = htmlspecialchars($row["Correo"]);
            $rol        = $row["Rol"];
            $archivo_n  = isset($_FILES['Archivo']['name']) ? htmlspecialchars($_FILES['Archivo']['name']) : "";

            // Resto del código para mostrar los detalles en HTML
            // ...

            // Cerrar la declaración preparada
            $stmt->close();
        } else {
            echo "No se encontró ningún empleado con ID: $id";
        }
    } else {
        echo "Error al ejecutar la consulta: " . $stmt->error;
    }
} else {
    echo "Error al preparar la consulta: " . $con->error;
}

// Cerrar la conexión
$con->close();
?>

<html>
<head>
    <title>Detalle de empleados</title>
</head>
<body>
    <?php if ($res->num_rows > 0): ?>
        Detalle del empleado <?php echo $id;?><br><hr>
        <a href="empleados_lista.php"> Regresar al listado </a><br><br>

        ID: <?php echo $id?><br>
        Nombre: <?php echo $nombre ?><br>
        Apellidos: <?php echo $apellidos ?><br>
        Rol: <?php echo ($rol == 1) ? "<b>Gerente</b>" : "<b>Ejecutivo</b>"; ?><br>
        Correo: <?php echo $correo?><br>
        Foto: <?php echo "<img src='Archivos/$archivo_n'>" ?><br>
    <?php endif; ?>
</body>
</html>
