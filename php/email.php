<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';

ob_start();

function enviarCorreoBienvenida($nombre, $email, $mensaje) {
    error_log("▶️ Función enviarCorreoBienvenida llamada con: Nombre: $nombre, Email: $email");

    // Validar el correo electrónico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        error_log("❌ Correo electrónico no válido: $email");
        return false;
    }


    // Asunto del correo
    $asunto = "¡Bienvenido $nombre!";

    // Leer contenido de bienvenida.html y reemplazar {{nombre}} por el nombre real
    $cuerpo = file_get_contents('../html/bienvenida.html');
    if ($cuerpo === false) {
        error_log("❌ No se pudo leer el archivo bienvenida.html");
        return false;
    } else {
        error_log("✅ Archivo bienvenida.html leído correctamente");
    }
    
    $cuerpo = str_replace('{{nombre}}', $nombre, $cuerpo);

    // Configurar PHPMailer
    $mail = new PHPMailer(true);
    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'tytacademy28@gmail.com'; // Asegúrate de que este correo sea correcto
        $mail->Password = 'hyec dmpy qpoe skhl'; // Contraseña de aplicación
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Habilitar depuración
        $mail->SMTPDebug = 3; // Cambia a 0 en producción
        $mail->Debugoutput = function ($str, $level) {
            error_log("SMTP [$level]: $str");
        };

        // Configuración del correo
        $mail->setFrom('tytacademy28@gmail.com', 'TYT Academy'); // El remitente debe coincidir con el correo autenticado
        $mail->addAddress($email, $nombre);
        $mail->addReplyTo('tytacademy28@gmail.com', 'Soporte');

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body = $cuerpo;

        // Enviar el correo
        error_log("📧 Enviando correo a $email...");
        $mail->send();
        error_log("Correo enviado exitosamente a $email");
        return true;
    } catch (Exception $e) {
        error_log("Error al enviar correo: {$mail->ErrorInfo}");
        return false;
    }
}

if (isset($_GET['nombre'], $_GET['email'], $_GET['mensaje'])) {
    $nombre = htmlspecialchars($_GET['nombre']);
    $email = filter_var($_GET['email'], FILTER_SANITIZE_EMAIL);
    $mensaje = htmlspecialchars($_GET['mensaje']);

    if (enviarCorreoBienvenida($nombre, $email, $mensaje)) {
        echo "El mensaje de bienvenida se ha enviado correctamente.";
    } else {
        echo "Hubo un error al enviar el mensaje.";
    }
} else {
    echo "Faltan datos en la solicitud";
}

ob_end_clean();

?>
