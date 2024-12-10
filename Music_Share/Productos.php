<?php
//Productos.php
session_start();
include 'Funciones/conecta.php';
$con = conecta();

$sql = "SELECT * FROM productos WHERE Status = 1 AND Eliminado = 0";
$res = $con->query($sql);
?>
<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="Diseños/Productos_Diseño.css">
    <head>
        <title> Music Share</title>
    </head>
    <body>
<!-- ------------------------------------------------------------------------ Script -->
<script src="JS/jquery-3.3.1.min.js"></script>
    <script>
        function Agregar(ID) {
            
            console.log(ID);
            var Cantidad = $('#Cantidad'+ID).val();
            $.ajax({
                type:       'POST',
                url:        'Funciones/Inserta_Producto.php',
                data:       'ID_Producto='+ID+'&Cantidad='+Cantidad,
                dataType:   'text',
                

                success: function (res) {
                    // Verifica el mensaje de respuesta y muestra la alerta correspondiente
                    console.log(res)
                    alert("Producto agregado al carrito"); // es invasivo pero por cuestion de tiempo se requiere
                },
                error: function() {
                    // Manejar errores de la solicitud Ajax si es necesario
                    alert("Error en la solicitud Ajax: ");
                }

            });
        }
    </script>
<!-- ------------------------------------------------------------------------ Encabezado de pagina Inicial -->
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
<!-- ------------------------------------------------------------------------- Productos de la pagina -->
    <section class="Tabla-Productos">
        <?php
        $con = conecta();

        $sql = "SELECT * FROM productos WHERE Status = 1 AND Eliminado = 0";
        $res = $con->query($sql);



        if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $id         = $row['ID'];
                $archivo    = $row['Archivo'];
                $nombre     = $row['Nombre'];
                $costo      = $row['Costo'];
                $codigo     = $row['Codigo'];
                $stock      = $row['Stock'];

                echo "<div class='Casilla-Producto'>";
                    echo "<a href='Productos-detalles.php?ID=$id' target='_self'>";
                        echo "<center>";
                        echo "<img class='img' src='Admin/Archivos/Productos/$archivo'>";
                        echo "</center>";
                        echo "<hr>";
                        echo "<p>$nombre</p>";
                    echo "</a>";
                    echo "<p class='Precio' > $ $costo</p>";
                    echo "<p class='Code'>Código: $codigo</p>";
                        // Aqui se realiza la validacion de usuario
                        if (isset($_SESSION['NombreUser']) && $_SESSION['NombreUser']) {
                            echo "<div class='accion'>";
                                echo "<a onclick='Agregar($id);' class='Boton'>Agregar al carrito</a>";
                                echo "<select name='Cantidad' id='Cantidad$id' value='1' class='Pzs' type='number'>
                                    <option value='0'>Selecciona</option>";
                                    for ($i = 1; $i <= $stock; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                    }
                                echo " </select>";
                            echo "</div>";
                            } else {
                                // En caso de no estar Logueado
                                echo "<button class='Boton'><a  href='Admin/index.php' >Inicia sesion para comprar </a></button>";
                            }
                echo "</div>";
            }
        } else {
            echo "<p> No se encontraron productos disponibles. </p>";
        }
        $con->close();
        ?>
    </section>
    <!-- ------------------------------------------------------------------- Encabezado final de pagina -->
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