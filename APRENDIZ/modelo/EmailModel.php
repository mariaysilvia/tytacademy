<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../../vendor/phpmailer/phpmailer/src/Exception.php';
require_once '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once '../../vendor/phpmailer/phpmailer/src/SMTP.php';

class EmailModel {
    private $mailer;
    private $config;

    public function __construct() {
        $this->mailer = new PHPMailer(true);
        $this->configurarSMTP();
    }

    private function configurarSMTP() {
        try {
            $this->mailer->isSMTP();
            $this->mailer->Host = 'smtp.gmail.com';
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = 'tytacademy28@gmail.com';
            $this->mailer->Password = 'hyec dmpy qpoe skhl';
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mailer->Port = 587;

            // Configuración del remitente
            $this->mailer->setFrom('tytacademy28@gmail.com', 'TYT Academy');
            $this->mailer->addReplyTo('tytacademy28@gmail.com', 'Soporte');

            // Configuración de depuración
            $this->mailer->SMTPDebug = 3;
            $this->mailer->Debugoutput = function ($str, $level) {
                error_log("SMTP [$level]: $str");
            };
        } catch (Exception $e) {
            error_log("Error al configurar SMTP: " . $e->getMessage());
            throw $e;
        }
    }

    public function enviarCorreoBienvenida($nombre, $email) {
        try {
            // Validar el correo electrónico
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                error_log("❌ Correo electrónico no válido: $email");
                return false;
            }

            // Configurar el correo
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($email, $nombre);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = "¡Bienvenido $nombre!";

            // Leer y personalizar la plantilla
            $cuerpo = file_get_contents('../vista/bienvenida.html');
            if ($cuerpo === false) {
                error_log("❌ No se pudo leer el archivo bienvenida.html");
                return false;
            }

            $cuerpo = str_replace('{{nombre}}', $nombre, $cuerpo);
            $cuerpo = str_replace('../publico/imagenes/firmaelectronica.jpg', 'cid:firmaelectronica', $cuerpo);

            // Adjuntar la imagen de la firma
            $this->mailer->addEmbeddedImage('../publico/imagenes/firmaelectronica.jpg', 'firmaelectronica');
            $this->mailer->Body = $cuerpo;

            // Enviar el correo
            error_log("📧 Enviando correo a $email...");
            $this->mailer->send();
            error_log("✅ Correo enviado exitosamente a $email");
            return true;

        } catch (Exception $e) {
            error_log("❌ Error al enviar correo: " . $e->getMessage());
            return false;
        }
    }
} 