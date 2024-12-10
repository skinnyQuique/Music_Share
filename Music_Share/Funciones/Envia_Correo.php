<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre     = $_POST["Nombre"];
    $correo     = $_POST["Correo"];
    $comentarios = $_POST["Comentarios"];

    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP de Gmail
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'skinnyquique28@gmail.com'; // Reemplaza con tu dirección de correo de Gmail
        $mail->Password   = 'iflmhtdkzfedgcsk'; // Reemplaza con tu contraseña de Gmail
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        // Destinatario y asunto del correo
        $mail->setFrom($correo, 'Tu Nombre');
        $mail->addAddress('skinnyquique28@gmail.com', 'Music Share');
        $mail->Subject = 'Asunto del correo';

        // Cuerpo del correo
        $mail->Body = "Nombre: $nombre\nCorreo: $correo\nComentarios: $comentarios";

        $mail->send();
        echo 'Correo enviado correctamente';
        header('Location: ../index.php');
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
}
?>