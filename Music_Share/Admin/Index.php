<?php
//Index.php
session_start();
if(isset($_SESSION['NombreUser'])) {
    header("Location: Bienvenido.php");
    exit();
}
?>
<html>
<head>
    <title>Log in</title>

    <link rel="stylesheet" href="Diseños/Index_Diseño.css"> <!-- Esto es para llamar la hoja de diseños -->
    <script src="JS/jquery-3.3.1.min.js"></script>
    <script>
        // Funcion para validar y enviar datos <------------------------------------------------------------------
        function ValidarDatos()
        { 
            var Correo = $('#Correo').val();
            var Pass = $('#Pass').val();

            if ( Correo === "" || Pass === "" ){   
                //alert("¡Felicidadades! Todos los campos estan llenos");
                $('#mensaje').html('Faltan campos por llenar');
                setTimeout("$('#mensaje').html('')", 5000);
                    
            } else {
                
                // Realizar la solicitud AJAX
                $.ajax({
                    type: "POST",
                    url: 'Funciones/Verifica_Usuario.php',
                    dataType: 'text',
                    data: 'Correo='+Correo+'&Pass='+Pass,
                    success: function(res) {
                        console.log(Correo);
                        if (res === '1') {
                            // Si el usuario existe, redirigir a bienvenido.php
                            window.location.replace("bienvenido.php");
                        } else {
                            // Si el usuario no existe, mostrar un mensaje de error
                            $("#mensaje").html('El usuario o la contraseña son incorrectos');
                            console.log(res)
                            setTimeout("$('#mensaje').html('')", 5000);
                        }
                    },
                    error: function() {
                        // Manejar errores de la solicitud AJAX si es necesario
                        $("#mensaje").html('Error en la solicitud AJAX.');
                        setTimeout("$('#mensaje').html('')", 5000);
                    }
                });
            }
        }   
    </script>
</head>
<body>
    <div class="Cuadro-Tiulo ">
        <h1 class="Titulo">Log in</h1>
    </div>
    <div class="LineaMenu" id="MenuLine" >
    </div>
    <br><br>
    
    <div class="Tabla" >
        <form name="Forma01" class="form" method="post"> <!-- Esta action="recibe.php" es para dirigir a otra pagina si asi se desea-->
            <h1 class="title">Log in</h1>

            <div class="Casillas">
                <input class="Ingreso" type="text"  name="Correo" id="Correo" placeholder="a">
                <label class="label" for="">Correo</label>
            </div>
            <div class="Casillas">
                <input class="Ingreso" name="Pass" id="Pass" type="password" placeholder="a">
                <label class="label" for="">Contraseña</label>
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