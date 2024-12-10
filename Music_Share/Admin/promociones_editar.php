<?php
//promociones_editar.php
session_start();
$Nombre = $_SESSION['NombreUser'];
if (!isset($_SESSION['NombreUser'])) {
    header("Location: index.php");
    exit();
}

require "Funciones/conecta.php";

// Verificar la existencia del parámetro ID

if (!isset($_GET['ID']) || !is_numeric($_GET['ID'])) { // Aqui se recibe el ID que se mando de la lista y evalua

    // Manejar el error, redireccionar o mostrar un mensaje en esos casos
    echo "ID no válido";
    exit;
}
$id = $_GET['ID'];
$con = conecta();

// Consulta preparada para prevenir inyección SQL
$sql = "SELECT * FROM promociones WHERE ID = ?";
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
            $nombre         = $row["Nombre"];
            $archivo        = $row["Archivo"];       // Estos datos son de la base de datos

        } else {
            echo "No se encontró ningún producto con ID: $id";
        }
    } else {
        echo "Error al ejecutar la consulta: " . $stmt->error;
    }

    // Cerrar la declaración preparada
    $stmt->close();
    
} else {
    echo "Error al preparar la consulta: " . $con->error;
}

// Cerrar la conexión del servidor
$con->close();
?>
<html>
<head>
    <title>Edicion Promocionales</title>

    <link rel="stylesheet" href="Diseños/promociones-editar_Diseño.css"> <!-- Esto es para llamar la hoja de diseños -->
    <script src="JS/jquery-3.3.1.min.js"></script>
    <script>
        // Funcion para validar y enviar datos <------------------------------------------------------------------
        function ValidarDatos()
        { 
            var Nombre      = $('#Nombre').val();
            var Archivo     = $('#Archivo').val();

            if ( Nombre == "" ){   
                console.log(Nombre);
		 		    //alert("¡Felicidadades! Todos los campos estan llenos");
                     $('#mensaje').html('Faltan campos por llenar');
                    setTimeout("$('#mensaje').html('')", 5000);
                    
		 	    } else {
                    //alert("Faltan campos por llenar ");
                    document.Forma01.method = 'Post';
                    document.Forma01.action = 'promociones_actualizar.php';
                    document.Forma01.submit();
			    }
        }
        // Esta funcion es para mostrar que se esta ingresando a la casilla <------------------------------------------------------------------
        //function entra(){
            //$('#mensaje').html('ENTRO'); 
            //setTimeout("$('#mensaje').html('')", 5000);
        //}
        // Funcion para validar existencia del correo <------------------------------------------------------------------
    </script>

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
            <h1 class="Titulo">Editar Promocionales</h1>
        </div>
        <div align="right">
        <a href = "promociones_lista.php">
            <button class="regreso">
                <b>Regresar al listado</b>
            </button>
        </a>
        </div>
    </div>
    <hr>
    
    <div class="Tabla" >
        <form name="Forma01" class="form" enctype="multipart/form-data" method="post"> <!-- Esta action="recibe.php" es para dirigir a otra pagina si asi se desea-->
            <h1 class="title">Actualizar</h1>
            <input type="hidden" name="ID" value="<?php echo $id; ?>">
            <input type="hidden" name="Archivo_Actual_tmp" value="<?php echo $archivo; ?>">
            <div class="Casillas">
                <input class="Ingreso" value="<?php echo $nombre ?>" type="text"  name="Nombre" id="Nombre" placeholder="a">
                <label class="label" for="">Nombre</label>
            </div>
            <div >
                <input type="file" id="Archivo" name="Archivo">
            </div>
            <div>
                <br>
                <div id="mensaje"></div>
                <input class="Boton" type="submit" value="Actualizar" onclick=" ValidarDatos(); return false;"> <!-- con return false se evita avanzar a "recibe.php"-->
                
            </div>
        </form>
    </div>
 <!-- Con onclick se manda llamar nuestra funcion para validar los datos-->

</body>
</html>