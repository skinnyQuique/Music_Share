<?php
//empleados_detalles.php
session_start();
$Nombre = $_SESSION['NombreUser'];
if (!isset($_SESSION['NombreUser'])) {
    header("Location: index.php");
    exit();
}
require "Funciones/conecta.php";

// Verificar la existencia del parámetro ID
if (!isset($_GET['ID']) || !is_numeric($_GET['ID'])) {
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
            $nombre     = $row["Nombre"];
            $apellidos  = $row["Apellidos"];
            $correo     = $row["Correo"];
            $rol        = $row["Rol"];
            $archivo    = $row["Archivo"];  

        } else {
            echo "No se encontró ningún empleado con ID: $id";
        }
    } else {
        echo "Error al ejecutar la consulta: " . $stmt->error;
    }

    // Cerrar la declaración preparada
    $stmt->close();
    
} else {
    echo "Error al preparar la consulta: " . $con->error;
}

// Cerrar la conexión
$con->close();
?>
<html>
<link rel="stylesheet" href="Diseños/empleados-detalle_Diseño.css"> <!-- Esto es para llamar la hoja de diseños -->
<head>
    <title>Detalle de empleados</title>
</head>
<body>
<div class="Cuadro-Tiulo ">
        <div class="IconMenu" id="MenuIcon" >&#9776;</div>
    </div>
    <div class="LineaMenu" id="MenuLine" >
        <!-- Contenido del menú -->
        <table>
            <tr class="tabla-menu">
                <td class="user-desing"> Bienvenido <?php echo $Nombre ?></td>
                <td class="op-menu"><a href="Bienvenido.php">Inicio</a></td>
                <td class="op-menu"><a href="empleados_lista.php">Empleados</a></td>
                <td class="op-menu"><a href="productos_lista.php">Productos</a></td>
                <td class="op-menu"><a href="promociones_lista.php">Promociones</a></td>
                <td class="op-menu"><a href="pedidos_lista.php">Pedido</a></td>
                <td class="op-menu"><a href="Funciones/Cerrar_Sesion.php">Cerrar sesion</a></td>    
            </tr>
        </table>
    </div>
    <script> // Esto corresponde al scrip para animaciones del cuadro inicial (menu)
        document.getElementById('MenuIcon').addEventListener('click', function() {
            document.getElementById('MenuLine').classList.toggle('activo');
            document.getElementById('MenuIcon').classList.toggle('icon-rot');
        });
        document.getElementById('MenuIcon').addEventListener('transitionend', function() {
            if (!document.getElementById('MenuLine').classList.contains('activo')) {
                document.getElementById('MenuIcon').classList.remove('icon-rot');
            }
        });
    </script>
    <div class="InvTabla">
        <div>
            <h1 class="Titulo">Detalles Empleados</h1>
        </div>
        <div align="right">
        <a href = "empleados_lista.php">
            <button class="regreso">
                <b>Regresar al listado</b>
            </button>
        </a>
        </div>
    </div>
    <hr>

    <center>
    <div class="Tabla-Mayor" id="TituloTB"> Detalles del empleado numero:  <?php echo $id;?></div>
    <div class="Tabla-Mayor">
        <div class="Tabla-menor">
            <table align="center" class="TBdatos">
                <td class="atencion"><?php echo "<img class='imagen' src='Archivos/Empleados/$archivo'>" ?></div><br>
                <td class="one"> <b class="letras">ID:</b><?php echo $id?></td><br>
                <td class="one"> <b class="letras">Status:</b> <?php echo ($row['Status'] ==1) ? "<b>Activo</b>" : "<b>Inactivo</b>"; ?></td><br>
                <td class="one"> <b class="letras">Rol:</b> <?php echo ($rol == 1) ? "<b>Gerente</b>" : "<b>Ejecutivo</b>"; ?></td><br>
                <td class="one"> <b class="letras">Nombre:</b> <?php echo $nombre ?></td><br>
                <td class="one"> <b class="letras">Apellidos:</b> <?php echo $apellidos ?></td><br>
                <td class="one"> <b class="letras">Correo:</b> <?php echo $correo?></td><br>
            </table>
            
        </div>
    </div>
    </center>
</body>
</html>
