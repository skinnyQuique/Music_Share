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
    <!-- --------------------------------------------------------- Programa principal -->
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
            // Consultar el pedido abierto del cliente
            $sql = "SELECT * FROM pedidos WHERE ID_Cliente = $id_cliente AND Status = 0";
            $res = $con->query($sql);

            if ($res->num_rows > 0) {
                $pedido = $res->fetch_assoc();
                $id_pedido = $pedido['ID'];


                // Consultar los productos del pedido abierto
                $sql = "SELECT pp.ID, pp.Cantidad, pr.Costo, pr.Stock, pr.Nombre as Nombre
                FROM pedidos_productos pp
                INNER JOIN productos pr ON pp.ID_Producto = pr.ID
                WHERE pp.ID_Pedido = $id_pedido";
                $res = $con->query($sql);
                $num = $res->num_rows;

                // Mostrar la lista de productos y opciones de gestión

                if ($res->num_rows > 0) {
                    echo "<h2 class='Titulo'>Carrito de Compras</h2>";

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
                            <div class='roles'>
                                <b class='font'>Acciones</b>
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
                            $stock      = $producto['Stock'];
                    // <--------------------------------------------------------------Aqui se crea la tabla con el listado de empleados
                        echo "<div class= 'tabla' id='producto_$id'> 
                            <div class='name'>
                                $nombre
                            </div>
                                
                            <div class='roles'>";
                                echo "<select name='Cantidad' id='Cantidad$id' data-id='$id' class='Pzs' type='number'>  
                                <option value='$cantidad'>$cantidad</option>";
                                for ($i = 1; $i <= min($stock, $cantidad); $i++) {
                                    echo "<option value='$i'>$i</option>";
                                }
                                echo " </select>";
                        echo "</div>
                                
                            <div class='roles'>
                                $ $precio
                            </div>";
                                $sub_total = $cantidad * $precio;
                            echo "<div class='roles'>
                                $sub_total
                            </div>
                            <div class='roles'  align='center' >
                                </a>
                                <a align='center' onclick='Eliminar($id);'>
                                    <img class='Eliminar' src='Diseños/imagenes-Diseño/trash.png'>
                                </a>
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
                        echo "<div class='Totalopen' id='TotalF'>
                            <b>$total</b>
                        </div>";
                    echo "</div>";

                echo "</div>";
                echo "<div class='botones'>";
                        // Botón para enviar el pedido
                        echo "<button class='Boton' onclick='Continuar()'>
                            Continuar
                        </button>";
                echo "</div>";
                } else {
                    echo "<p>No hay productos en el carrito.</p>";
                }
            } else {
                header("Location: Carrito-Closed.php");
            }

            // Cierra la conexión
            $con->close();
        ?>
   <!-- -----------------------------------------------------------------------------Funciones script -->
   <script src="JS/jquery-3.3.1.min.js"></script>
        <script>
            //-------------------------------------------------------------------
            function obtenerIDProducto() {
                // Lógica para obtener el ID del producto actual
                // Puedes obtenerlo desde el nombre del elemento o de donde sea apropiado en tu código
                // Ejemplo: supongamos que el ID está en el formato 'Cantidad123', donde 123 es el ID
                var idElemento = $('select[name="Cantidad"]').attr('id');
                var partes = idElemento.split('Cantidad');
                return partes[1]; // Esto obtendrá el ID del producto
            }
            //-------------------------------------------------------------------
            function Eliminar(id){
                var Seguro = confirm(' ¿Esta seguro que desea eliminar a este producto de su carrito? ');
                console.log(id);
                if (Seguro) {
                    $.ajax({
                        
                        type: "POST",
                        url: "Funciones/producto_elimina.php",
                        data: { ID: id }, // Usar el ID pasado como parámetro
                        
                        success: function(res) {
                            console.log(res);
                            if (res == 0) {
                                alert("Producto eliminado exitosamente.");
                                $('#producto_'+ id).hide();
                            } else {
                                // Error en la operación
                                alert("Error al ocultar el producto.");
                            }
                        },
                        error: function() {
                            alert("Ajax no encontrado");
                        }
                    });
                }
            }
            var cantidadesActualizadas = {};
            // ---------------------------------------------------------------- Funcion para actualizar
            function Continuar() { 
                $.ajax({
                    type: "POST",
                    url: "Funciones/revisa_pedido.php",
                    data: { cantidades: cantidadesActualizadas }, // Envia el objeto con las cantidades
                    success: function(res) {
                        console.log(res);
                        if (res == 0) {
                            window.location.href = 'Carrito-Closed.php';
                        } else {
                            alert("Error al actualizar las cantidades.");
                        }
                    },
                    error: function() {
                        alert("Error en la solicitud AJAX.");
                    }
                });
            }
            //-------------------------------------------------------------------
            $('select[name="Cantidad"]').change(function() {
                var maxCantidad = $(this).find('option:selected').val(); // Obtener el valor seleccionado
                $(this).attr('max', maxCantidad); // Establecer el nuevo valor máximo
            });

            $(document).ready(function() {
                $('select[name="Cantidad"]').change(function() {
                    var maxCantidad = $(this).find('option:selected').val();
                    $(this).attr('max', maxCantidad);
                    var id = $(this).data('id');
                    var cantidad = $(this).val();
                    cantidadesActualizadas[id] = cantidad;
                });
            });
        </script>
<!-- ---------------------------------------------------------------Parte de abajo de la pagina -->
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