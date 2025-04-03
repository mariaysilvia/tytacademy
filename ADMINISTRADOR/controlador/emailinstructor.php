<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/phpmailer/phpmailer/src/Exception.php';
require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../vendor/phpmailer/phpmailer/src/SMTP.php';

ob_start();

function enviarCorreoBienvenida($nombre, $email, $clave, $modulo, $documento) {
    error_log("▶️ Función enviarCorreoBienvenida llamada con: Nombre: $nombre, Email: $email, Módulo: $modulo, Documento: $documento");

    // Validar el correo electrónico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        error_log("❌ Correo electrónico no válido: $email");
        return false;
    }

    // Obtener el nombre del módulo
    include '../../config/conexion.php';
    $stmt = $pdo->prepare("SELECT modulo FROM Modulo WHERE idModulo = ?");
    $stmt->execute([$modulo]);
    $moduloData = $stmt->fetch(PDO::FETCH_ASSOC);
    $nombreModulo = $moduloData ? $moduloData['modulo'] : 'Módulo no especificado';

    // Asunto del correo
    $asunto = "¡Bienvenido a TYT Academy, $nombre!";

    // Leer contenido de bienvenida.html
    $cuerpo = file_get_contents('../vista/bienvenidainstructor.html');
    if ($cuerpo === false) {
        error_log("❌ No se pudo leer el archivo bienvenidainstructor.html");
        return false;
    }

    // Reemplazar las variables en el template
    $cuerpo = str_replace('{{nombre}}', $nombre, $cuerpo);
    $cuerpo = str_replace('{{email}}', $email, $cuerpo);
    $cuerpo = str_replace('{{clave}}', $clave, $cuerpo);
    $cuerpo = str_replace('{{modulo}}', $nombreModulo, $cuerpo);
    $cuerpo = str_replace('{{documento}}', $documento, $cuerpo);

    // Configurar PHPMailer
    $mail = new PHPMailer(true);
    try {
        // Habilitar depuración
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = function($str, $level) {
            error_log("SMTP [$level]: $str");
        };

        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'tytacademy28@gmail.com';
        $mail->Password = 'hyec dmpy qpoe skhl';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Configuración del correo
        $mail->setFrom('tytacademy28@gmail.com', 'TYT Academy');
        $mail->addAddress($email, $nombre);
        $mail->addReplyTo('tytacademy28@gmail.com', 'Soporte');

        // Verificar y adjuntar la imagen de la firma electrónica
        $rutaImagen = '../../ADMINISTRADOR/publico/imagenes/firmaelectronica.jpg';
        error_log("Intentando cargar imagen desde: $rutaImagen");
        
        if (file_exists($rutaImagen)) {
            error_log("✅ Imagen encontrada en: $rutaImagen");
            $mail->addEmbeddedImage($rutaImagen, 'firmaelectronica');
        } else {
            error_log("❌ No se encontró la imagen en: $rutaImagen");
            // Continuar sin la imagen en lugar de fallar
        }

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body = $cuerpo;

        // Enviar el correo
        error_log("📧 Enviando correo a $email...");
        $mail->send();
        error_log("✅ Correo enviado exitosamente a $email");
        return true;
    } catch (Exception $e) {
        error_log("❌ Error al enviar correo: " . $e->getMessage());
        error_log("Detalles del error: " . $mail->ErrorInfo);
        return false;
    }
}

if (isset($_GET['nombre'], $_GET['email'], $_GET['clave'], $_GET['modulo'], $_GET['documento'])) {
    $nombre = htmlspecialchars($_GET['nombre']);
    $email = filter_var($_GET['email'], FILTER_SANITIZE_EMAIL);
    $clave = htmlspecialchars($_GET['clave']);
    $modulo = htmlspecialchars($_GET['modulo']);
    $documento = htmlspecialchars($_GET['documento']);

    if (enviarCorreoBienvenida($nombre, $email, $clave, $modulo, $documento)) {
        echo "El mensaje de bienvenida se ha enviado correctamente.";
    } else {
        echo "Hubo un error al enviar el mensaje.";
    }
} else {
    echo "Faltan datos en la solicitud";
}

ob_end_clean();

?>