<?php
//pedidos_lista.php
session_start();
$Nombre = $_SESSION['NombreUser'];
if (!isset($_SESSION['NombreUser'])) {
    header("Location: index.php");
    exit();
}
require "Funciones/conecta.php";
$con = conecta();

$sql = "SELECT p.ID, p.ID_Cliente, p.Fecha, e.Nombre, e.Apellidos
        FROM pedidos p
        INNER JOIN empleados e ON p.ID_Cliente = e.ID
        WHERE p.Status = 1";
$res = $con->query($sql);
$num = $res->num_rows;

?>
<html>
<head>
    <title> Pedidos lista</title>
</head>
<link rel="stylesheet" href="Diseños/empleados-lista_Diseño.css"> <!-- Esto es para llamar la hoja de diseños -->

<body bgcolor="#e0e0e0"> <!-- Coloqué el gris como fondo de pagina por defecto-->

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
<!-- <-----------------------------------------------------Esto corresponde al boton de nuevo empleado y ubicacion de pagina-->
<div class="InvTabla">
    <div>
            <h1 class="Titulo">Lista pedidos cerrados</h1>
    </div>
</div>
<hr>
<?php
// <---------------------Aqui es la formacion para la fila del titulo de nuestra tabla con el encabezado de cada seccion
echo "<div class= 'Tabla-Mayor'>";
    echo "<div class='tabla' id='TituloTB'> 
            <div class='id' id='Columid'>
                <b class='font'>ID</b>
            </div>
            <div class='name'>
                <b class='font'>Nombre</b>
            </div>
            <div class='roles'>
                <b class='font'>Fecha</b>
            </div>
            <div class='Acciones' id='Accion'>
                <b class='font'>Accion</b>
            </div>
        </div>";

// <----------------------------------------------------------Aqui comienza el recibir los datos a las variables 

while ($row = $res->fetch_array()){
    $id             = $row["ID"];
    $id_cliente     = $row["ID_Cliente"];
    $fecha          = $row["Fecha"];
    $nombre_empleado = $row["Nombre"];
    $apellidos_empleado = $row["Apellidos"];
// <--------------------------------------------------------------Aqui se crea la tabla con el listado de empleados
    echo "<div class= 'tabla'>
                <div class='id' >
                    $id
                </div>";
                echo " <div class='name'>
                    $nombre_empleado $apellidos_empleado
                </div>";
                echo " <div class='roles'>
                     $fecha
                </div>";
// <---------------------------------------------------------------------------Esto corresponde al las Acciones
                echo "<div class='Acciones'  align='center' >
                        <a href='pedidos_detalles.php?ID=$id'>
                            <img class='Eliminar' src='Imagenes/View.png' >
                        </a>
                </div>";
    echo "</div>";
    }
echo "</div>";
?>
    
