<?php
//Productos_alta.php
session_start();
$Nombre = $_SESSION['NombreUser'];
if (!isset($_SESSION['NombreUser'])) {
    header("Location: index.php");
    exit();
}
?>
<html>
<head>
    <title>Alta de productos</title>

    <link rel="stylesheet" href="Diseños/productos-alta_Diseño.css"> <!-- Esto es para llamar la hoja de diseños -->
    <script src="JS/jquery-3.3.1.min.js"></script>
    <script>
        // Funcion para validar y enviar datos <------------------------------------------------------------------
        function ValidarDatos()
        { 
            var Nombre = $('#Nombre').val();
            var Codigo = $('#Codigo').val();
            var Costo = $('#Costo').val();
            var Stock = $('#Stock').val();
            var Archivo = $('#Archivo').val();
            var Descripcion = $('#Descripcion').val();

            if ( Nombre === "" || Codigo === "" || Costo === "" || Stock === "" || Descripcion === ""){   
                console.log(Nombre)
		 		    //alert("¡Felicidadades! Todos los campos estan llenos");
                     $('#mensaje').html('Faltan campos por llenar');
                    setTimeout("$('#mensaje').html('')", 5000);
                    
                } else {
                    // Validación del archivo
                    var fileInput = document.getElementById('Archivo');
                    if (fileInput.files.length === 0) {
                        // No se ha seleccionado ningún archivo
                        $('#mensaje').html('Debe seleccionar un archivo');
                        setTimeout("$('#mensaje').html('')", 5000);
                    } else {
                        // Se ha seleccionado un archivo
                        // Puedes agregar aquí más validaciones si es necesario
                        // Luego, procede con la subida del formulario
                        document.Forma01.method = 'Post';
                        document.Forma01.action = 'productos_salva.php';
                        document.Forma01.submit();
                    }
               }    
        }
        // Esta funcion es para mostrar que se esta ingresando a la casilla <------------------------------------------------------------------
        //function entra(){
            //$('#mensaje').html('ENTRO'); 
            //setTimeout("$('#mensaje').html('')", 5000);
        //}
        // Funcion para validar existencia del codigo <------------------------------------------------------------------
        function sale(Codigo){
            var Codigo = $('#Codigo').val();
            console.log(Codigo);
            $.ajax({
                type: "POST",
                url: 'Funciones/Verifica_Codigo.php?Codigo='+Codigo,
                
                success: function (res) {
                    console.log(res);
                    if (res == '1') {
                        // El codigo ya existe en la base de datos
                        $('#Codigo').val('');
                        $('#mensaje_Correo').html('El codigo: "' + Codigo + '" ya existe');
                        setTimeout("$('#mensaje_Correo').html('')", 5000);
                    } else {
                        // El codigo no existe, puedes realizar otra acción si es necesario
                        
                    }
                },
                error: function() {
                    // Manejar errores de la solicitud Ajax si es necesario
                    alert("Error en la solicitud Ajax: ");
                }
            });
        }
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
            <h1 class="Titulo">Alta Productos</h1>
        </div>
        <div align="right">
        <a href = "productos_lista.php">
            <button class="regreso">
                <b>Regresar al listado</b>
            </button>
        </a>
        </div>
    </div>
    <hr>
    <div class="Tabla" >
        <form name="Forma01" class="form" enctype="multipart/form-data" method="post"> <!-- Esta action="recibe.php" es para dirigir a otra pagina si asi se desea-->
            <h1 class="title">Ingreso</h1>

            <div class="Casillas">
                <input class="Ingreso" type="text"  name="Nombre" id="Nombre" placeholder="a">
                <label class="label" for="">Nombre</label>
            </div>
            <div class="Casillas">
                <input class="Ingreso" type="text" name="Costo" id="Costo" placeholder="a">
                <label class="label" for="">Costo</label>
            </div>
            
            <div class="Casillas">
                <input class="Ingreso" onblur="sale();" type="text" name="Codigo" id="Codigo" placeholder="a">
                <label class="label" for="">Codigo</label>
            </div>
            <div id="mensaje_Correo"></div><br>
            <div class="Casillas">
                <input class="Ingreso" name="Stock" id="Stock" type="text" placeholder="a">
                <label class="label" for="">Stock</label>
            </div>
            <div class="Casillas">
                <input class="Ingreso" name="Descripcion" id="Descripcion" type="text" placeholder="a">
                <label class="label" for="">Descripcion</label>
            </div>
            <div >
                <input type="file" id="Archivo" name="Archivo">
            </div>
            <div>
                <br>
                <div id="mensaje"></div>
                <input class="Boton" type="submit" value="Salvar" onclick=" ValidarDatos(); return false;"> <!-- con return false se evita avanzar a "recibe.php"-->
                
            </div>
        </form>
    </div>
 <!-- Con onclick se manda llamar nuestra funcion para validar los datos-->

</body>
</html>