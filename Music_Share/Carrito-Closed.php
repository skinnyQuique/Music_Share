<?php
//Productos.php
session_start();
include 'Funciones/conecta.php';
$con = conecta();


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="Diseños/Carrito_Diseño.css">
        <title>Carrito</title>
    </head>
    <body>
        <header>    
            <table align="center" class="TablaNav"> 
                <tr >
                    <td class="OpNav"><a href="index.php"> <img class="icono" src="Diseños/imagenes-Diseño/Home.png"> Home</a></td>
                    <td class="OpNav"><a href="Productos.php"> <img class="icono" src="Diseños/imagenes-Diseño/Productos.png"> Productos</a></td>
                    <td class="OpNav"><a href="Contacto.php"> <img class="icono" src="Diseños/imagenes-Diseño/Contacto.png"> Contacto</a></td>
                    <td class="OpNav"><a href="Carrito-Open.php"> <img class="icono" src="Diseños/imagenes-Diseño/Carrito.png"> Carrito</a></td>
                </tr>
            </table>
        </header>

        <?php
            // Obtener el ID del cliente de la sesión
            $id_cliente = $_SESSION['IDUser'];
            // Consultar el pedido cerrado del cliente
            $sql = "SELECT * FROM pedidos WHERE ID_Cliente = $id_cliente AND Status = 0";
            $res = $con->query($sql);

            if ($res->num_rows > 0) {
                $pedido = $res->fetch_assoc();
                $id_pedido = $pedido['ID'];


                // Consultar los productos del pedido abierto
                $sql = "SELECT pp.ID, pp.Cantidad, pr.Costo, pr.Nombre as Nombre
                    FROM pedidos_productos pp
                    INNER JOIN productos pr ON pp.ID_Producto = pr.ID
                    WHERE pp.ID_Pedido = $id_pedido";
                $res = $con->query($sql);
                $num = $res->num_rows;

                // Mostrar la lista de productos y opciones de gestión

                if ($res->num_rows > 0) {
                    echo "<h2 class='Titulo' >Carrito de Compras</h2>";


                    echo "<div class= 'Tabla-Mayor'>";
                        echo "<div class='tabla' id='TituloTB'> 
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
                    // Botón para enviar el pedido
                    echo "<button class='Boton' onclick='Finalizar()'>Enviar Pedido</button>";
                } else {
                    echo "<p>No hay productos en el carrito.</p>";
                }
            } else {
                echo "<center><h1 class='Titulo'>No hay un pedido abierto.</h1><center>";
            }

            // Cierra la conexión
            $con->close();
        ?>
        <script src="JS/jquery-3.3.1.min.js"></script>
        <script>
            //-------------------------------------------------------------------
            function Finalizar() {
                var confirmarEnvio = confirm("¿Está seguro de que desea enviar el pedido?");

                if (confirmarEnvio) {
                    $.ajax({
                        type: "POST",
                        url: "Funciones/actualiza_status.php",
                        data: { action: 'Finalizar' },
                        success: function (res) {
                            console.log(res);
                            if (res == 0) {
                                window.location.href = 'index.php';
                            } else {
                                alert("Error al enviar el pedido.");
                            }
                        },
                        error: function () {
                            alert("Error en la solicitud AJAX.");
                        }
                    });
                }
            };
        </script>
        <footer>
            Todos los derechos reservados 2023 | terminos y condiciones | <br>
            | Política de privacidad | Redes sociales | <br>
            <a><img class="iconos" src="Diseños/imagenes-Diseño/Correo.png"></a>
            <a><img class="iconos" src="Diseños/imagenes-Diseño/Facebook.png"></a>
            <a><img class="iconos" src="Diseños/imagenes-Diseño/Insta.png"></a>
            <a><img class="iconos" src="Diseños/imagenes-Diseño/X.png"></a>
        </footer>
    </body>
</html>