<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';

if (isset($_GET['nombre'], $_GET['email'], $_GET['mensaje'])) {
    $nombre = htmlspecialchars($_GET['nombre']);
    $email = filter_var($_GET['email'], FILTER_SANITIZE_EMAIL);
    $mensaje = htmlspecialchars($_GET['mensaje']);

    //validar el correo electronico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Correo electrónico no valido.";
        exit;
    }


    //Destinario del correo
    $destinatario ="guadalupepatinoperez218@gmail.com";

    //Asunto del correo
    $asunto = "Hola mundo$nombre";

    //Cuerpo del correo
    $cuerpo ="
    <html>
    <head>
        <tittle>Nuevo mensaje</titlle>
    </head>
    <body>
        <p><strong>Nombre:</strong> $nombre</php>
        <p><strong>Correo Electrónico:</strong> $email</php>
        <p><strong>Mensaje:</strong></php>
        <p>$mensaje</php>
    </body>
    </html>
    ";

    //Configurar PHPMailer
    $mail = new PHPMailer(true);
    try {
        //Configuracion del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; //usuario SMTP
        $mail-> SMTPAuth = true;
        $mail->Username = 'guadalupepatinoperez218@gmail.com'; //este es mi correo
        $mail->Password = 'mfle xpxp ctzn qbpj';//contraseña de correo
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        //Configuración del correo
        $mail->setFrom($email, $nombre);
        $mail->addAddress($destinatario);
        $mail->addReplyTo($email, $nombre);


        //Contenido del correo
        $mail->isHtml(true);
        $mail->Subject = $asunto;
        $mail ->Body= $cuerpo;

        //enviar el correo
        $mail->send();
        echo "El mensaje se ha enviado correctamente.";
    }catch(Exception $e) {
        echo "Hubo un error al enviar el mensaje. Mailer Error: ($mail->ErrorInfo)";
    }
}else{
    echo"Faltan datos en la solicitud";
}

?>

