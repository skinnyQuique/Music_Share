<?php
// Contacto.php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="Diseños/Contacto_Diseño.css">
    <title>Contacto</title>
</head>
<body>
    <header>    
        <table align="center" class="TablaNav"> 
            <tr >
                <td class="OpNav"><a href="index.php"> <img class="icono" src="Diseños/imagenes-Diseño/Home.png"> Home</a></td>
                <td class="OpNav"><a href="Productos.php"> <img class="icono" src="Diseños/imagenes-Diseño/Productos.png"> Productos</a></td>
                <td class="OpNav"><a href="Contacto.php"> <img class="icono" src="Diseños/imagenes-Diseño/Contacto.png"> Contacto</a></td>
                <?php   
                    if (isset($_SESSION['NombreUser']) && $_SESSION['NombreUser']) {
                        echo "<td class='OpNav'><a href='Carrito-Open.php'> <img class='icono' src='Diseños/imagenes-Diseño/Carrito.png'> Carrito</a></td>";
                        $NombreU = $_SESSION['NombreUser'];
                        echo "<td class='OPNav'> Bienvenido $NombreU </td> ";
                    } else {
                        echo "<td class='OPNav'> <button class='Boton'><a  href='Admin/index.php' >Inicia sesion </a></button> </td>";
                    }
                ?>
            </tr>
        </table>
    </header>

    <section class="contacto-form">
        <div class="Tabla" >
            <form class="form" action="Funciones/Envia_Correo.php" method="post">
                <h1 class="title">Contacto</h1>
                    
                <div class="Casillas">
                    <input class="Ingreso" type="text" id="nombre" name="Nombre" required>
                    <label class="label" for="Nombre">Nombre:</label>
                </div>
                
                <div class="Casillas">   
                    <input class="Ingreso" type="text" id="Apellidos" name="Apellidos" required>
                    <label class="label" for="Apellidos">Apellidos:</label>
                </div>
                <div class="Casillas">
                    <input class="Ingreso" type="email" id="correo" name="Correo" required>
                    <label class="label" for="Correo">Correo:</label>
                </div>
                <div class="Casillas">
                    <textarea class="Ingreso" id="comentarios" name="Comentarios" rows="4" required></textarea>
                    <label class="label" for="Comentarios">Comentarios:</label>
                </div>
                <div>
                    <br>
                    <input class="Boton" type="submit"></input>
                </div>
            </form>
    </section>

    <footer>
        Todos los derechos reservados 2023 | terminos y condiciones | <br>
        | Política de privacidad | Redes sociales | <br>
        <a href="#"><img class="iconos" src="Diseños/imagenes-Diseño/Correo.png"></a>
        <a href="#"><img class="iconos" src="Diseños/imagenes-Diseño/Facebook.png"></a>
        <a href="#"><img class="iconos" src="Diseños/imagenes-Diseño/Insta.png"></a>
        <a href="#"><img class="iconos" src="Diseños/imagenes-Diseño/X.png"></a>
    </footer>
</body>
</html>
