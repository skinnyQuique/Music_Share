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
// Verificar la existencia del parámetro ID
if (!isset($_GET['ID']) || !is_numeric($_GET['ID'])) {
    echo "ID no válido";
    exit;
}
$id_ped = $_GET['ID'];
$con = conecta();

// Consultar los productos del pedido abierto
$sql = "SELECT pp.ID, pp.Cantidad, pr.Costo, pr.Nombre as Nombre
FROM pedidos_productos pp
INNER JOIN productos pr ON pp.ID_Producto = pr.ID
WHERE pp.ID_Pedido = $id_ped";
$res = $con->query($sql);
$num = $res->num_rows;

?>
<html>
<head>
    <title> Pedidos Detalles</title>
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
            <h1 class="Titulo">Pedidos detalles</h1>
    </div>
    <div align="right">
        <a href = "pedidos_lista.php">
            <button class="NewBoton">
                <b>Regresar</b>
            </button>
        </a>
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
            <b class='font'>Cantidad</b>
        </div>
        <div class='roles'>
            <b class='font'>Precio Unitario</b>
        </div>
        <div class='roles'>
            <b class='font'>Total</b>
        </div>
    </div>";

    // <----------------------------------------------------------Aqui comienza el recibir los datos a las variables 
    $total = 0; // Inicializa la variable total
    $sub_total = 0;
    while ($producto = $res->fetch_assoc()) {
        $nombre     = $producto['Nombre'];
        $cantidad   = $producto['Cantidad'];
        $precio     = $producto['Costo'];
        $id         = $producto['ID'];
// <--------------------------------------------------------------Aqui se crea la tabla con el listado de empleados
    echo "<div class= 'tabla' id='producto_$id'> 
        <div class='id'>
            $id
        </div>
        <div class='name'>
            $nombre
        </div>
                
        <div class='roles'>
            $cantidad
        </div>
                
        <div class='roles'>
            $ $precio
        </div>";
            $sub_total = $cantidad * $precio;
        echo "<div class='roles'>
            $sub_total
        </div>
    </div>";
    // Suma el precio al total
    $total += $sub_total;
    }
    // Muestra el total después de mostrar todos los productos
    echo "<div class='Container' id='TotalT'>";
        echo "<div class='TEXTOT' id='TotalT'>
            <b>Total Final</b>
        </div>";
        echo "<div class='Total' id='TotalF'>
            <b>$total</b>
        </div>";
    echo "</div>";

echo "</div>";
  
?>
    
