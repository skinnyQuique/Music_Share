<?php
//Empleados_alta.php
session_start();
$Nombre = $_SESSION['NombreUser'];
if (!isset($_SESSION['NombreUser'])) {
    header("Location: index.php");
    exit();
}
?>
<html>
<head>
    <title>Alta de empleados</title>

    <link rel="stylesheet" href="Diseños/empleados-alta_Diseño.css"> <!-- Esto es para llamar la hoja de diseños -->
    <script src="JS/jquery-3.3.1.min.js"></script>
    <script>
        // Funcion para validar y enviar datos <------------------------------------------------------------------
        function ValidarDatos()
        { 
            var Nombre = $('#Nombre').val();
            var Apellidos = $('#Apellidos').val();
            var Correo = $('#Correo').val();
            var Pass = $('#Pass').val();
            var Rol = $('Rol').val();
            var Archivo = $('#Archivo').val();

            if ( Nombre === "" || Apellidos === "" || Correo === "" || Pass === "" || Rol === "0"){   
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
                        document.Forma01.action = 'empleados_salva.php';
                        document.Forma01.submit();
                    }
               }    
        }
        // Esta funcion es para mostrar que se esta ingresando a la casilla <------------------------------------------------------------------
        //function entra(){
            //$('#mensaje').html('ENTRO'); 
            //setTimeout("$('#mensaje').html('')", 5000);
        //}
        // Funcion para validar existencia del correo <------------------------------------------------------------------
        function sale(Correo){
            var Correo = $('#Correo').val();
            console.log(Correo);
            $.ajax({
                type: "POST",
                url: 'Funciones/Verifica_Correo.php?Correo='+Correo,
                
                success: function (res) {
                    console.log(res);
                    if (res == '1') {
                        // El correo ya existe en la base de datos
                        $('#Correo').val('');
                        $('#mensaje_Correo').html('El correo: "' + Correo + '" ya existe');
                        setTimeout("$('#mensaje_Correo').html('')", 5000);
                    } else {
                        // El correo no existe, puedes realizar otra acción si es necesario
                        
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
            <h1 class="Titulo">Alta Empleados</h1>
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
    <div class="Tabla" >
        <form name="Forma01" class="form" enctype="multipart/form-data" method="post"> <!-- Esta action="recibe.php" es para dirigir a otra pagina si asi se desea-->
            <h1 class="title">Sign up</h1>

            <div class="Casillas">
                <input class="Ingreso" type="text"  name="Nombre" id="Nombre" placeholder="a">
                <label class="label" for="">Nombre</label>
            </div>
            <div class="Casillas">
                <input class="Ingreso" type="text" name="Apellidos" id="Apellidos" placeholder="a">
                <label class="label" for="">Apellidos</label>
            </div>
            
            <div class="Casillas">
                <input class="Ingreso" onfocus="entra();" onblur="sale();" type="text" name="Correo" id="Correo" placeholder="a">
                <label class="label" for="">Correo</label>
            </div>
            <div id="mensaje_Correo"></div><br>
            <div class="Casillas">
                <input class="Ingreso" name="Pass" id="Pass" type="password" placeholder="a">
                <label class="label" for="">Contraseña</label>
            </div>
            <div>
                <select class="Seleccionar" name="Rol" id="Rol">
                    <option value="0">Seleccionar </option>
                    <option value="1">Gerente </option>
                    <option value="2">Ejecitivo </option>
                </select>
            </div><br>
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