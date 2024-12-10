<?php
//Empleados_lista.php
session_start();
$Nombre = $_SESSION['NombreUser'];
if (!isset($_SESSION['NombreUser'])) {
    header("Location: index.php");
    exit();
}
require "Funciones/conecta.php";
$con = conecta();

$sql = "SELECT * FROM empleados
        WHERE Status = 1 AND Eliminado = 0";
$res = $con->query($sql);
$num = $res->num_rows;
?>

<html>
<head>
    <title> Lista de Empleados</title>
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
            <h1 class="Titulo">Lista Empleados</h1>
        </div>
        <div align="right">
            <a href = "empleados_alta.php">
                <button class="NewBoton">
                    <b>Nuevo Empleado</b>
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
                <b class='font'>Puesto</b>
            </div>
            <div class='Correo'>
                <b class='font'>Correo</b>
            </div>
            <div class='Acciones' id='Accion'>
                <b class='font'>Accion</b>
            </div>
        </div>";

// <----------------------------------------------------------Aqui comienza el recibir los datos a las variables
while ($row = $res->fetch_array()){
    $id         = $row["ID"];
    $nombre     = $row["Nombre"];
    $apellidos  = $row["Apellidos"];
    $correo     = $row["Correo"];
    $rol        = $row["Rol"];
// <--------------------------------------------------------------Aqui se crea la tabla con el listado de empleados
    echo "<div class= 'tabla' id='empleado_$id'>
                <div class='id' >
                    $id
                </div>  
                <div class='name'>
                    $apellidos $nombre 
                </div>";
// <--------------------------------------------------Este if marca para saber el rol que cumple mediante el value
                if ($rol == 1){
                    echo " <div class='roles'><b>Gerente</b></div>";
                } else {
                    echo " <div class ='roles'><b>Ejecutivo</b></div>";
                }
                echo "<div class='Correo'>
                        $correo
                </div>";  
// <---------------------------------------------------------------------------Esto corresponde al las Acciones
                echo "<div class='Acciones'  align='center' >
                        <a href='empleados_detalle.php?ID=$id'>
                            <img class='Eliminar' src='Imagenes/View.png' >
                        </a>
                        <a href='empleados_editar.php?ID=$id'>
                            <img class='Eliminar' src='Imagenes/Edit.png' >
                        </a>
                        <a align='center' onclick='Eliminar($id);'>
                            <img class='Eliminar' src='Imagenes/trash.png'>
                        </a>
                </div>";
    echo "</div>";
    }
echo "</div>";
    
    
?>
<!---------------------------------------------------------------- Funcion para eliminar con ajax-->
<script src="JS/jquery-3.3.1.min.js"></script>
<script>
    function Eliminar(id){
        var Seguro = confirm(' ¿Esta seguro que desea eliminar a este empleado? ');

        if (Seguro) {
            $.ajax({
            type: "POST",
            url: "empleados_elimina.php",
            data: { ID: id }, // Usar el ID pasado como parámetro
            
            success: function(res) {
                console.log(res);
                if (res == 0) {
                    alert("Empleado ocultado exitosamente.");
                    $('#empleado_' + id).hide();
                } else {
                    // Error en la operación
                    alert("Error al ocultar el empleado.");
                }
            },
            error: function() {
                alert("Ajax no encontrado");
            }
        });
        }
    }
</script>;
</body>

</html>
